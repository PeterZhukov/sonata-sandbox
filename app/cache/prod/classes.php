<?php 
namespace Symfony\Component\Templating
{
interface TemplateReferenceInterface
{
public function all();
public function set($name, $value);
public function get($name);
public function getPath();
public function getLogicalName();
public function __toString();
}
}
namespace Symfony\Component\Templating
{
class TemplateReference implements TemplateReferenceInterface
{
protected $parameters;
public function __construct($name = null, $engine = null)
{
$this->parameters = array('name'=> $name,'engine'=> $engine,
);
}
public function __toString()
{
return $this->getLogicalName();
}
public function set($name, $value)
{
if (array_key_exists($name, $this->parameters)) {
$this->parameters[$name] = $value;
} else {
throw new \InvalidArgumentException(sprintf('The template does not support the "%s" parameter.', $name));
}
return $this;
}
public function get($name)
{
if (array_key_exists($name, $this->parameters)) {
return $this->parameters[$name];
}
throw new \InvalidArgumentException(sprintf('The template does not support the "%s" parameter.', $name));
}
public function all()
{
return $this->parameters;
}
public function getPath()
{
return $this->parameters['name'];
}
public function getLogicalName()
{
return $this->parameters['name'];
}
}
}
namespace Symfony\Bundle\FrameworkBundle\Templating
{
use Symfony\Component\Templating\TemplateReference as BaseTemplateReference;
class TemplateReference extends BaseTemplateReference
{
public function __construct($bundle = null, $controller = null, $name = null, $format = null, $engine = null)
{
$this->parameters = array('bundle'=> $bundle,'controller'=> $controller,'name'=> $name,'format'=> $format,'engine'=> $engine,
);
}
public function getPath()
{
$controller = str_replace('\\','/', $this->get('controller'));
$path = (empty($controller) ?'': $controller.'/').$this->get('name').'.'.$this->get('format').'.'.$this->get('engine');
return empty($this->parameters['bundle']) ?'views/'.$path :'@'.$this->get('bundle').'/Resources/views/'.$path;
}
public function getLogicalName()
{
return sprintf('%s:%s:%s.%s.%s', $this->parameters['bundle'], $this->parameters['controller'], $this->parameters['name'], $this->parameters['format'], $this->parameters['engine']);
}
}
}
namespace Symfony\Component\Routing\Generator
{
interface ConfigurableRequirementsInterface
{
public function setStrictRequirements($enabled);
public function isStrictRequirements();
}
}
namespace Symfony\Component\Routing\Generator
{
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Psr\Log\LoggerInterface;
class UrlGenerator implements UrlGeneratorInterface, ConfigurableRequirementsInterface
{
protected $routes;
protected $context;
protected $strictRequirements = true;
protected $logger;
protected $decodedChars = array('%2F'=>'/','%40'=>'@','%3A'=>':','%3B'=>';','%2C'=>',','%3D'=>'=','%2B'=>'+','%21'=>'!','%2A'=>'*','%7C'=>'|',
);
public function __construct(RouteCollection $routes, RequestContext $context, LoggerInterface $logger = null)
{
$this->routes = $routes;
$this->context = $context;
$this->logger = $logger;
}
public function setContext(RequestContext $context)
{
$this->context = $context;
}
public function getContext()
{
return $this->context;
}
public function setStrictRequirements($enabled)
{
$this->strictRequirements = null === $enabled ? null : (bool) $enabled;
}
public function isStrictRequirements()
{
return $this->strictRequirements;
}
public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
{
if (null === $route = $this->routes->get($name)) {
throw new RouteNotFoundException(sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $name));
}
$compiledRoute = $route->compile();
return $this->doGenerate($compiledRoute->getVariables(), $route->getDefaults(), $route->getRequirements(), $compiledRoute->getTokens(), $parameters, $name, $referenceType, $compiledRoute->getHostTokens(), $route->getSchemes());
}
protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, array $requiredSchemes = array())
{
$variables = array_flip($variables);
$mergedParams = array_replace($defaults, $this->context->getParameters(), $parameters);
if ($diff = array_diff_key($variables, $mergedParams)) {
throw new MissingMandatoryParametersException(sprintf('Some mandatory parameters are missing ("%s") to generate a URL for route "%s".', implode('", "', array_keys($diff)), $name));
}
$url ='';
$optional = true;
foreach ($tokens as $token) {
if ('variable'=== $token[0]) {
if (!$optional || !array_key_exists($token[3], $defaults) || null !== $mergedParams[$token[3]] && (string) $mergedParams[$token[3]] !== (string) $defaults[$token[3]]) {
if (null !== $this->strictRequirements && !preg_match('#^'.$token[2].'$#', $mergedParams[$token[3]])) {
$message = sprintf('Parameter "%s" for route "%s" must match "%s" ("%s" given) to generate a corresponding URL.', $token[3], $name, $token[2], $mergedParams[$token[3]]);
if ($this->strictRequirements) {
throw new InvalidParameterException($message);
}
if ($this->logger) {
$this->logger->error($message);
}
return;
}
$url = $token[1].$mergedParams[$token[3]].$url;
$optional = false;
}
} else {
$url = $token[1].$url;
$optional = false;
}
}
if (''=== $url) {
$url ='/';
}
$url = strtr(rawurlencode($url), $this->decodedChars);
$url = strtr($url, array('/../'=>'/%2E%2E/','/./'=>'/%2E/'));
if ('/..'=== substr($url, -3)) {
$url = substr($url, 0, -2).'%2E%2E';
} elseif ('/.'=== substr($url, -2)) {
$url = substr($url, 0, -1).'%2E';
}
$schemeAuthority ='';
if ($host = $this->context->getHost()) {
$scheme = $this->context->getScheme();
if ($requiredSchemes) {
$schemeMatched = false;
foreach ($requiredSchemes as $requiredScheme) {
if ($scheme === $requiredScheme) {
$schemeMatched = true;
break;
}
}
if (!$schemeMatched) {
$referenceType = self::ABSOLUTE_URL;
$scheme = current($requiredSchemes);
}
} elseif (isset($requirements['_scheme']) && ($req = strtolower($requirements['_scheme'])) && $scheme !== $req) {
$referenceType = self::ABSOLUTE_URL;
$scheme = $req;
}
if ($hostTokens) {
$routeHost ='';
foreach ($hostTokens as $token) {
if ('variable'=== $token[0]) {
if (null !== $this->strictRequirements && !preg_match('#^'.$token[2].'$#i', $mergedParams[$token[3]])) {
$message = sprintf('Parameter "%s" for route "%s" must match "%s" ("%s" given) to generate a corresponding URL.', $token[3], $name, $token[2], $mergedParams[$token[3]]);
if ($this->strictRequirements) {
throw new InvalidParameterException($message);
}
if ($this->logger) {
$this->logger->error($message);
}
return;
}
$routeHost = $token[1].$mergedParams[$token[3]].$routeHost;
} else {
$routeHost = $token[1].$routeHost;
}
}
if ($routeHost !== $host) {
$host = $routeHost;
if (self::ABSOLUTE_URL !== $referenceType) {
$referenceType = self::NETWORK_PATH;
}
}
}
if (self::ABSOLUTE_URL === $referenceType || self::NETWORK_PATH === $referenceType) {
$port ='';
if ('http'=== $scheme && 80 != $this->context->getHttpPort()) {
$port =':'.$this->context->getHttpPort();
} elseif ('https'=== $scheme && 443 != $this->context->getHttpsPort()) {
$port =':'.$this->context->getHttpsPort();
}
$schemeAuthority = self::NETWORK_PATH === $referenceType ?'//': "$scheme://";
$schemeAuthority .= $host.$port;
}
}
if (self::RELATIVE_PATH === $referenceType) {
$url = self::getRelativePath($this->context->getPathInfo(), $url);
} else {
$url = $schemeAuthority.$this->context->getBaseUrl().$url;
}
$extra = array_diff_key($parameters, $variables, $defaults);
if ($extra && $query = http_build_query($extra,'','&')) {
$url .='?'.strtr($query, array('%2F'=>'/'));
}
return $url;
}
public static function getRelativePath($basePath, $targetPath)
{
if ($basePath === $targetPath) {
return'';
}
$sourceDirs = explode('/', isset($basePath[0]) &&'/'=== $basePath[0] ? substr($basePath, 1) : $basePath);
$targetDirs = explode('/', isset($targetPath[0]) &&'/'=== $targetPath[0] ? substr($targetPath, 1) : $targetPath);
array_pop($sourceDirs);
$targetFile = array_pop($targetDirs);
foreach ($sourceDirs as $i => $dir) {
if (isset($targetDirs[$i]) && $dir === $targetDirs[$i]) {
unset($sourceDirs[$i], $targetDirs[$i]);
} else {
break;
}
}
$targetDirs[] = $targetFile;
$path = str_repeat('../', count($sourceDirs)).implode('/', $targetDirs);
return''=== $path ||'/'=== $path[0]
|| false !== ($colonPos = strpos($path,':')) && ($colonPos < ($slashPos = strpos($path,'/')) || false === $slashPos)
? "./$path" : $path;
}
}
}
namespace Symfony\Component\Routing\Matcher
{
interface RedirectableUrlMatcherInterface
{
public function redirect($path, $route, $scheme = null);
}
}
namespace Symfony\Component\Routing\Matcher
{
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
class UrlMatcher implements UrlMatcherInterface, RequestMatcherInterface
{
const REQUIREMENT_MATCH = 0;
const REQUIREMENT_MISMATCH = 1;
const ROUTE_MATCH = 2;
protected $context;
protected $allow = array();
protected $routes;
protected $request;
protected $expressionLanguage;
protected $expressionLanguageProviders = array();
public function __construct(RouteCollection $routes, RequestContext $context)
{
$this->routes = $routes;
$this->context = $context;
}
public function setContext(RequestContext $context)
{
$this->context = $context;
}
public function getContext()
{
return $this->context;
}
public function match($pathinfo)
{
$this->allow = array();
if ($ret = $this->matchCollection(rawurldecode($pathinfo), $this->routes)) {
return $ret;
}
throw 0 < count($this->allow)
? new MethodNotAllowedException(array_unique(array_map('strtoupper', $this->allow)))
: new ResourceNotFoundException(sprintf('No routes found for "%s".', $pathinfo));
}
public function matchRequest(Request $request)
{
$this->request = $request;
$ret = $this->match($request->getPathInfo());
$this->request = null;
return $ret;
}
public function addExpressionLanguageProvider(ExpressionFunctionProviderInterface $provider)
{
$this->expressionLanguageProviders[] = $provider;
}
protected function matchCollection($pathinfo, RouteCollection $routes)
{
foreach ($routes as $name => $route) {
$compiledRoute = $route->compile();
if (''!== $compiledRoute->getStaticPrefix() && 0 !== strpos($pathinfo, $compiledRoute->getStaticPrefix())) {
continue;
}
if (!preg_match($compiledRoute->getRegex(), $pathinfo, $matches)) {
continue;
}
$hostMatches = array();
if ($compiledRoute->getHostRegex() && !preg_match($compiledRoute->getHostRegex(), $this->context->getHost(), $hostMatches)) {
continue;
}
if ($req = $route->getRequirement('_method')) {
if ('HEAD'=== $method = $this->context->getMethod()) {
$method ='GET';
}
if (!in_array($method, $req = explode('|', strtoupper($req)))) {
$this->allow = array_merge($this->allow, $req);
continue;
}
}
$status = $this->handleRouteRequirements($pathinfo, $name, $route);
if (self::ROUTE_MATCH === $status[0]) {
return $status[1];
}
if (self::REQUIREMENT_MISMATCH === $status[0]) {
continue;
}
return $this->getAttributes($route, $name, array_replace($matches, $hostMatches));
}
}
protected function getAttributes(Route $route, $name, array $attributes)
{
$attributes['_route'] = $name;
return $this->mergeDefaults($attributes, $route->getDefaults());
}
protected function handleRouteRequirements($pathinfo, $name, Route $route)
{
if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), array('context'=> $this->context,'request'=> $this->request))) {
return array(self::REQUIREMENT_MISMATCH, null);
}
$scheme = $this->context->getScheme();
$status = $route->getSchemes() && !$route->hasScheme($scheme) ? self::REQUIREMENT_MISMATCH : self::REQUIREMENT_MATCH;
return array($status, null);
}
protected function mergeDefaults($params, $defaults)
{
foreach ($params as $key => $value) {
if (!is_int($key)) {
$defaults[$key] = $value;
}
}
return $defaults;
}
protected function getExpressionLanguage()
{
if (null === $this->expressionLanguage) {
if (!class_exists('Symfony\Component\ExpressionLanguage\ExpressionLanguage')) {
throw new \RuntimeException('Unable to use expressions as the Symfony ExpressionLanguage component is not installed.');
}
$this->expressionLanguage = new ExpressionLanguage(null, $this->expressionLanguageProviders);
}
return $this->expressionLanguage;
}
}
}
namespace Symfony\Component\Routing\Matcher
{
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Route;
abstract class RedirectableUrlMatcher extends UrlMatcher implements RedirectableUrlMatcherInterface
{
public function match($pathinfo)
{
try {
$parameters = parent::match($pathinfo);
} catch (ResourceNotFoundException $e) {
if ('/'=== substr($pathinfo, -1) || !in_array($this->context->getMethod(), array('HEAD','GET'))) {
throw $e;
}
try {
parent::match($pathinfo.'/');
return $this->redirect($pathinfo.'/', null);
} catch (ResourceNotFoundException $e2) {
throw $e;
}
}
return $parameters;
}
protected function handleRouteRequirements($pathinfo, $name, Route $route)
{
if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), array('context'=> $this->context,'request'=> $this->request))) {
return array(self::REQUIREMENT_MISMATCH, null);
}
$scheme = $this->context->getScheme();
$schemes = $route->getSchemes();
if ($schemes && !$route->hasScheme($scheme)) {
return array(self::ROUTE_MATCH, $this->redirect($pathinfo, $name, current($schemes)));
}
return array(self::REQUIREMENT_MATCH, null);
}
}
}
namespace Symfony\Bundle\FrameworkBundle\Routing
{
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher as BaseMatcher;
class RedirectableUrlMatcher extends BaseMatcher
{
public function redirect($path, $route, $scheme = null)
{
return array('_controller'=>'Symfony\\Bundle\\FrameworkBundle\\Controller\\RedirectController::urlRedirectAction','path'=> $path,'permanent'=> true,'scheme'=> $scheme,'httpPort'=> $this->context->getHttpPort(),'httpsPort'=> $this->context->getHttpsPort(),'_route'=> $route,
);
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\Event;
class KernelEvent extends Event
{
private $kernel;
private $request;
private $requestType;
public function __construct(HttpKernelInterface $kernel, Request $request, $requestType)
{
$this->kernel = $kernel;
$this->request = $request;
$this->requestType = $requestType;
}
public function getKernel()
{
return $this->kernel;
}
public function getRequest()
{
return $this->request;
}
public function getRequestType()
{
return $this->requestType;
}
public function isMasterRequest()
{
return HttpKernelInterface::MASTER_REQUEST === $this->requestType;
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
class FilterControllerEvent extends KernelEvent
{
private $controller;
public function __construct(HttpKernelInterface $kernel, $controller, Request $request, $requestType)
{
parent::__construct($kernel, $request, $requestType);
$this->setController($controller);
}
public function getController()
{
return $this->controller;
}
public function setController($controller)
{
if (!is_callable($controller)) {
throw new \LogicException(sprintf('The controller must be a callable (%s given).', $this->varToString($controller)));
}
$this->controller = $controller;
}
private function varToString($var)
{
if (is_object($var)) {
return sprintf('Object(%s)', get_class($var));
}
if (is_array($var)) {
$a = array();
foreach ($var as $k => $v) {
$a[] = sprintf('%s => %s', $k, $this->varToString($v));
}
return sprintf('Array(%s)', implode(', ', $a));
}
if (is_resource($var)) {
return sprintf('Resource(%s)', get_resource_type($var));
}
if (null === $var) {
return'null';
}
if (false === $var) {
return'false';
}
if (true === $var) {
return'true';
}
return (string) $var;
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class FilterResponseEvent extends KernelEvent
{
private $response;
public function __construct(HttpKernelInterface $kernel, Request $request, $requestType, Response $response)
{
parent::__construct($kernel, $request, $requestType);
$this->setResponse($response);
}
public function getResponse()
{
return $this->response;
}
public function setResponse(Response $response)
{
$this->response = $response;
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpFoundation\Response;
class GetResponseEvent extends KernelEvent
{
private $response;
public function getResponse()
{
return $this->response;
}
public function setResponse(Response $response)
{
$this->response = $response;
$this->stopPropagation();
}
public function hasResponse()
{
return null !== $this->response;
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
class GetResponseForControllerResultEvent extends GetResponseEvent
{
private $controllerResult;
public function __construct(HttpKernelInterface $kernel, Request $request, $requestType, $controllerResult)
{
parent::__construct($kernel, $request, $requestType);
$this->controllerResult = $controllerResult;
}
public function getControllerResult()
{
return $this->controllerResult;
}
public function setControllerResult($controllerResult)
{
$this->controllerResult = $controllerResult;
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
class GetResponseForExceptionEvent extends GetResponseEvent
{
private $exception;
public function __construct(HttpKernelInterface $kernel, Request $request, $requestType, \Exception $e)
{
parent::__construct($kernel, $request, $requestType);
$this->setException($e);
}
public function getException()
{
return $this->exception;
}
public function setException(\Exception $exception)
{
$this->exception = $exception;
}
}
}
namespace
{
class Twig_Markup implements Countable
{
protected $content;
protected $charset;
public function __construct($content, $charset)
{
$this->content = (string) $content;
$this->charset = $charset;
}
public function __toString()
{
return $this->content;
}
public function count()
{
return function_exists('mb_get_info') ? mb_strlen($this->content, $this->charset) : strlen($this->content);
}
}
}
namespace Monolog\Formatter
{
interface FormatterInterface
{
public function format(array $record);
public function formatBatch(array $records);
}
}
namespace Monolog\Formatter
{
use Exception;
class NormalizerFormatter implements FormatterInterface
{
const SIMPLE_DATE ="Y-m-d H:i:s";
protected $dateFormat;
public function __construct($dateFormat = null)
{
$this->dateFormat = $dateFormat ?: static::SIMPLE_DATE;
if (!function_exists('json_encode')) {
throw new \RuntimeException('PHP\'s json extension is required to use Monolog\'s NormalizerFormatter');
}
}
public function format(array $record)
{
return $this->normalize($record);
}
public function formatBatch(array $records)
{
foreach ($records as $key => $record) {
$records[$key] = $this->format($record);
}
return $records;
}
protected function normalize($data)
{
if (null === $data || is_scalar($data)) {
if (is_float($data)) {
if (is_infinite($data)) {
return ($data > 0 ?'':'-') .'INF';
}
if (is_nan($data)) {
return'NaN';
}
}
return $data;
}
if (is_array($data) || $data instanceof \Traversable) {
$normalized = array();
$count = 1;
foreach ($data as $key => $value) {
if ($count++ >= 1000) {
$normalized['...'] ='Over 1000 items, aborting normalization';
break;
}
$normalized[$key] = $this->normalize($value);
}
return $normalized;
}
if ($data instanceof \DateTime) {
return $data->format($this->dateFormat);
}
if (is_object($data)) {
if ($data instanceof Exception) {
return $this->normalizeException($data);
}
return sprintf("[object] (%s: %s)", get_class($data), $this->toJson($data, true));
}
if (is_resource($data)) {
return'[resource]';
}
return'[unknown('.gettype($data).')]';
}
protected function normalizeException(Exception $e)
{
$data = array('class'=> get_class($e),'message'=> $e->getMessage(),'code'=> $e->getCode(),'file'=> $e->getFile().':'.$e->getLine(),
);
$trace = $e->getTrace();
foreach ($trace as $frame) {
if (isset($frame['file'])) {
$data['trace'][] = $frame['file'].':'.$frame['line'];
} else {
$data['trace'][] = $this->toJson($this->normalize($frame), true);
}
}
if ($previous = $e->getPrevious()) {
$data['previous'] = $this->normalizeException($previous);
}
return $data;
}
protected function toJson($data, $ignoreErrors = false)
{
if ($ignoreErrors) {
if (version_compare(PHP_VERSION,'5.4.0','>=')) {
return @json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
return @json_encode($data);
}
if (version_compare(PHP_VERSION,'5.4.0','>=')) {
return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
return json_encode($data);
}
}
}
namespace Monolog\Formatter
{
use Exception;
class LineFormatter extends NormalizerFormatter
{
const SIMPLE_FORMAT ="[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
protected $format;
protected $allowInlineLineBreaks;
protected $ignoreEmptyContextAndExtra;
protected $includeStacktraces;
public function __construct($format = null, $dateFormat = null, $allowInlineLineBreaks = false, $ignoreEmptyContextAndExtra = false)
{
$this->format = $format ?: static::SIMPLE_FORMAT;
$this->allowInlineLineBreaks = $allowInlineLineBreaks;
$this->ignoreEmptyContextAndExtra = $ignoreEmptyContextAndExtra;
parent::__construct($dateFormat);
}
public function includeStacktraces($include = true)
{
$this->includeStacktraces = $include;
if ($this->includeStacktraces) {
$this->allowInlineLineBreaks = true;
}
}
public function allowInlineLineBreaks($allow = true)
{
$this->allowInlineLineBreaks = $allow;
}
public function ignoreEmptyContextAndExtra($ignore = true)
{
$this->ignoreEmptyContextAndExtra = $ignore;
}
public function format(array $record)
{
$vars = parent::format($record);
$output = $this->format;
foreach ($vars['extra'] as $var => $val) {
if (false !== strpos($output,'%extra.'.$var.'%')) {
$output = str_replace('%extra.'.$var.'%', $this->stringify($val), $output);
unset($vars['extra'][$var]);
}
}
if ($this->ignoreEmptyContextAndExtra) {
if (empty($vars['context'])) {
unset($vars['context']);
$output = str_replace('%context%','', $output);
}
if (empty($vars['extra'])) {
unset($vars['extra']);
$output = str_replace('%extra%','', $output);
}
}
foreach ($vars as $var => $val) {
if (false !== strpos($output,'%'.$var.'%')) {
$output = str_replace('%'.$var.'%', $this->stringify($val), $output);
}
}
return $output;
}
public function formatBatch(array $records)
{
$message ='';
foreach ($records as $record) {
$message .= $this->format($record);
}
return $message;
}
public function stringify($value)
{
return $this->replaceNewlines($this->convertToString($value));
}
protected function normalizeException(Exception $e)
{
$previousText ='';
if ($previous = $e->getPrevious()) {
do {
$previousText .=', '.get_class($previous).'(code: '.$previous->getCode().'): '.$previous->getMessage().' at '.$previous->getFile().':'.$previous->getLine();
} while ($previous = $previous->getPrevious());
}
$str ='[object] ('.get_class($e).'(code: '.$e->getCode().'): '.$e->getMessage().' at '.$e->getFile().':'.$e->getLine().$previousText.')';
if ($this->includeStacktraces) {
$str .="\n[stacktrace]\n".$e->getTraceAsString();
}
return $str;
}
protected function convertToString($data)
{
if (null === $data || is_bool($data)) {
return var_export($data, true);
}
if (is_scalar($data)) {
return (string) $data;
}
if (version_compare(PHP_VERSION,'5.4.0','>=')) {
return $this->toJson($data, true);
}
return str_replace('\\/','/', @json_encode($data));
}
protected function replaceNewlines($str)
{
if ($this->allowInlineLineBreaks) {
return $str;
}
return strtr($str, array("\r\n"=>' ',"\r"=>' ',"\n"=>' '));
}
}
}
namespace Monolog\Handler
{
use Monolog\Logger;
class FilterHandler extends AbstractHandler
{
protected $handler;
protected $acceptedLevels;
protected $bubble;
public function __construct($handler, $minLevelOrList = Logger::DEBUG, $maxLevel = Logger::EMERGENCY, $bubble = true)
{
$this->handler = $handler;
$this->bubble = $bubble;
$this->setAcceptedLevels($minLevelOrList, $maxLevel);
if (!$this->handler instanceof HandlerInterface && !is_callable($this->handler)) {
throw new \RuntimeException("The given handler (".json_encode($this->handler).") is not a callable nor a Monolog\Handler\HandlerInterface object");
}
}
public function getAcceptedLevels()
{
return array_flip($this->acceptedLevels);
}
public function setAcceptedLevels($minLevelOrList = Logger::DEBUG, $maxLevel = Logger::EMERGENCY)
{
if (is_array($minLevelOrList)) {
$acceptedLevels = array_map('Monolog\Logger::toMonologLevel', $minLevelOrList);
} else {
$minLevelOrList = Logger::toMonologLevel($minLevelOrList);
$maxLevel = Logger::toMonologLevel($maxLevel);
$acceptedLevels = array_values(array_filter(Logger::getLevels(), function ($level) use ($minLevelOrList, $maxLevel) {
return $level >= $minLevelOrList && $level <= $maxLevel;
}));
}
$this->acceptedLevels = array_flip($acceptedLevels);
}
public function isHandling(array $record)
{
return isset($this->acceptedLevels[$record['level']]);
}
public function handle(array $record)
{
if (!$this->isHandling($record)) {
return false;
}
if (!$this->handler instanceof HandlerInterface) {
$this->handler = call_user_func($this->handler, $record, $this);
if (!$this->handler instanceof HandlerInterface) {
throw new \RuntimeException("The factory callable should return a HandlerInterface");
}
}
if ($this->processors) {
foreach ($this->processors as $processor) {
$record = call_user_func($processor, $record);
}
}
$this->handler->handle($record);
return false === $this->bubble;
}
public function handleBatch(array $records)
{
$filtered = array();
foreach ($records as $record) {
if ($this->isHandling($record)) {
$filtered[] = $record;
}
}
$this->handler->handleBatch($filtered);
}
}
}
namespace Monolog\Handler
{
use Monolog\Logger;
class TestHandler extends AbstractProcessingHandler
{
protected $records = array();
protected $recordsByLevel = array();
public function getRecords()
{
return $this->records;
}
public function hasEmergency($record)
{
return $this->hasRecord($record, Logger::EMERGENCY);
}
public function hasAlert($record)
{
return $this->hasRecord($record, Logger::ALERT);
}
public function hasCritical($record)
{
return $this->hasRecord($record, Logger::CRITICAL);
}
public function hasError($record)
{
return $this->hasRecord($record, Logger::ERROR);
}
public function hasWarning($record)
{
return $this->hasRecord($record, Logger::WARNING);
}
public function hasNotice($record)
{
return $this->hasRecord($record, Logger::NOTICE);
}
public function hasInfo($record)
{
return $this->hasRecord($record, Logger::INFO);
}
public function hasDebug($record)
{
return $this->hasRecord($record, Logger::DEBUG);
}
public function hasEmergencyRecords()
{
return isset($this->recordsByLevel[Logger::EMERGENCY]);
}
public function hasAlertRecords()
{
return isset($this->recordsByLevel[Logger::ALERT]);
}
public function hasCriticalRecords()
{
return isset($this->recordsByLevel[Logger::CRITICAL]);
}
public function hasErrorRecords()
{
return isset($this->recordsByLevel[Logger::ERROR]);
}
public function hasWarningRecords()
{
return isset($this->recordsByLevel[Logger::WARNING]);
}
public function hasNoticeRecords()
{
return isset($this->recordsByLevel[Logger::NOTICE]);
}
public function hasInfoRecords()
{
return isset($this->recordsByLevel[Logger::INFO]);
}
public function hasDebugRecords()
{
return isset($this->recordsByLevel[Logger::DEBUG]);
}
protected function hasRecord($record, $level)
{
if (!isset($this->recordsByLevel[$level])) {
return false;
}
if (is_array($record)) {
$record = $record['message'];
}
foreach ($this->recordsByLevel[$level] as $rec) {
if ($rec['message'] === $record) {
return true;
}
}
return false;
}
protected function write(array $record)
{
$this->recordsByLevel[$record['level']][] = $record;
$this->records[] = $record;
}
}
}
namespace Symfony\Bridge\Monolog\Handler
{
use Monolog\Logger;
use Monolog\Handler\TestHandler;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
class DebugHandler extends TestHandler implements DebugLoggerInterface
{
public function getLogs()
{
$records = array();
foreach ($this->records as $record) {
$records[] = array('timestamp'=> $record['datetime']->getTimestamp(),'message'=> $record['message'],'priority'=> $record['level'],'priorityName'=> $record['level_name'],'context'=> $record['context'],
);
}
return $records;
}
public function countErrors()
{
$cnt = 0;
$levels = array(Logger::ERROR, Logger::CRITICAL, Logger::ALERT, Logger::EMERGENCY);
foreach ($levels as $level) {
if (isset($this->recordsByLevel[$level])) {
$cnt += count($this->recordsByLevel[$level]);
}
}
return $cnt;
}
}
}
namespace Doctrine\Common
{
use Doctrine\Common\Lexer\AbstractLexer;
abstract class Lexer extends AbstractLexer
{
}
}
namespace Sonata\PageBundle\Generator
{
class Mustache
{
public static function replace($string, array $parameters)
{
$replacer = function ($match) use ($parameters) {
return isset($parameters[$match[1]]) ? $parameters[$match[1]] : $match[0];
};
return preg_replace_callback('/{{\s*(.+?)\s*}}/', $replacer, $string);
}
}
}
namespace Sonata\PageBundle\Model
{
class SnapshotChildrenCollection implements \Countable, \IteratorAggregate, \ArrayAccess
{
protected $transformer;
protected $page;
protected $collection;
public function __construct(TransformerInterface $transformer, PageInterface $page)
{
$this->transformer = $transformer;
$this->page = $page;
}
private function load()
{
if ($this->collection == null) {
$this->collection = $this->transformer->getChildren($this->page);
}
}
public function offsetUnset($offset)
{
$this->load();
return $this->collection->offsetUnset($offset);
}
public function offsetSet($offset, $value)
{
$this->load();
return $this->collection->offsetSet($offset, $value);
}
public function offsetGet($offset)
{
$this->load();
return $this->collection->offsetGet($offset);
}
public function offsetExists($offset)
{
$this->load();
return $this->collection->offsetExists($offset);
}
public function getIterator()
{
$this->load();
return $this->collection->getIterator();
}
public function count()
{
$this->load();
return $this->collection->count();
}
}
}
namespace Sonata\PageBundle\Model
{
use Sonata\PageBundle\Model\PageBlockInterface;
use Serializable;
class SnapshotPageProxy implements PageInterface, Serializable
{
private $manager;
private $snapshot;
private $page;
private $target;
private $parents;
public function __construct(SnapshotManagerInterface $manager, TransformerInterface $transformer, SnapshotInterface $snapshot)
{
$this->manager = $manager;
$this->snapshot = $snapshot;
$this->transformer = $transformer;
}
public function getPage()
{
$this->load();
return $this->page;
}
private function load()
{
if (!$this->page && $this->transformer) {
$this->page = $this->transformer->load($this->snapshot);
}
}
public function __call($method, $arguments)
{
return call_user_func_array(array($this->getPage(), $method), $arguments);
}
public function addChildren(PageInterface $children)
{
$this->getPage()->addChildren($children);
}
public function setHeaders(array $headers = array())
{
$this->getPage()->setHeaders($headers);
}
public function addHeader($name, $value)
{
$this->getPage()->addHeader($name, $value);
}
public function getHeaders()
{
return $this->getPage()->getHeaders();
}
public function getChildren()
{
if (!$this->getPage()->getChildren()->count()) {
$this->getPage()->setChildren(new SnapshotChildrenCollection($this->transformer, $this->getPage()));
}
return $this->getPage()->getChildren();
}
public function addBlocks(PageBlockInterface $block)
{
$this->getPage()->addBlocks($block);
}
public function getBlocks()
{
if (!count($this->getPage()->getBlocks())) {
$content = $this->snapshot->getContent();
foreach ($content['blocks'] as $block) {
$b = $this->transformer->loadBlock($block, $this);
$this->addBlocks($b);
$b->setPage($this);
}
}
return $this->getPage()->getBlocks();
}
public function setTarget(PageInterface $target = null)
{
$this->target = $target;
}
public function getTarget()
{
if ($this->target === null) {
$content = $this->snapshot->getContent();
if (isset($content['target_id'])) {
$target = $this->manager->findEnableSnapshot(array('pageId'=> $content['target_id']
));
if ($target) {
$this->setTarget(new SnapshotPageProxy($this->manager, $this->transformer, $target));
} else {
$this->target = false;
}
}
}
return $this->target ?: null;
}
public function getParent($level = -1)
{
$parents = $this->getParents();
if ($level < 0) {
$level = count($parents) + $level;
}
return isset($parents[$level]) ? $parents[$level] : null;
}
public function setParents(array $parents)
{
$this->parents = $parents;
}
public function getParents()
{
if (!$this->parents) {
$parents = array();
$snapshot = $this->snapshot;
while ($snapshot) {
$content = $snapshot->getContent();
if (!$content['parent_id']) {
break;
}
$snapshot = $this->manager->findEnableSnapshot(array('pageId'=> $content['parent_id']
));
if (!$snapshot) {
break;
}
$parents[] = new SnapshotPageProxy($this->manager, $this->transformer, $snapshot);
}
$this->setParents(array_reverse($parents));
}
return $this->parents;
}
public function setParent(PageInterface $parent = null)
{
$this->getPage()->setParent($parent);
}
public function setTemplateCode($templateCode)
{
$this->getPage()->setTemplateCode($templateCode);
}
public function getTemplateCode()
{
return $this->getPage()->getTemplateCode();
}
public function setDecorate($decorate)
{
$this->getPage()->setDecorate($decorate);
}
public function getDecorate()
{
return $this->getPage()->getDecorate();
}
public function isHybrid()
{
return $this->getPage()->isHybrid();
}
public function setPosition($position)
{
$this->getPage()->setPosition($position);
}
public function getPosition()
{
return $this->getPage()->getPosition();
}
public function setRequestMethod($method)
{
$this->getPage()->setRequestMethod($method);
}
public function getRequestMethod()
{
return $this->getPage()->getRequestMethod();
}
public function getId()
{
return $this->getPage()->getId();
}
public function setId($id)
{
$this->getPage()->setId($id);
}
public function getRouteName()
{
return $this->getPage()->getRouteName();
}
public function setRouteName($routeName)
{
$this->getPage()->setRouteName($routeName);
}
public function setEnabled($enabled)
{
$this->getPage()->setEnabled($enabled);
}
public function getEnabled()
{
return $this->getPage()->getEnabled();
}
public function setName($name)
{
$this->getPage()->setName($name);
}
public function getName()
{
return $this->getPage()->getName();
}
public function setSlug($slug)
{
$this->getPage()->setSlug($slug);
}
public function getSlug()
{
return $this->getPage()->getSlug();
}
public function setUrl($url)
{
$this->getPage()->setUrl($url);
}
public function getUrl()
{
return $this->getPage()->getUrl();
}
public function setCustomUrl($customUrl)
{
$this->getPage()->setCustomUrl($customUrl);
}
public function getCustomUrl()
{
return $this->getPage()->getCustomUrl();
}
public function setMetaKeyword($metaKeyword)
{
$this->getPage()->setMetaKeyword($metaKeyword);
}
public function getMetaKeyword()
{
return $this->getPage()->getMetaKeyword();
}
public function setMetaDescription($metaDescription)
{
$this->getPage()->setMetaDescription($metaDescription);
}
public function getMetaDescription()
{
return $this->getPage()->getMetaDescription();
}
public function setJavascript($javascript)
{
$this->getPage()->setJavascript($javascript);
}
public function getJavascript()
{
return $this->getPage()->getJavascript();
}
public function setStylesheet($stylesheet)
{
$this->getPage()->setStylesheet($stylesheet);
}
public function getStylesheet()
{
return $this->getPage()->getStylesheet();
}
public function getPageAlias()
{
return $this->getPage()->getPageAlias();
}
public function setPageAlias($pageAlias)
{
return $this->getPage()->setPageAlias($pageAlias);
}
public function setCreatedAt(\DateTime $createdAt = null)
{
$this->getPage()->setCreatedAt($createdAt);
}
public function getCreatedAt()
{
return $this->getPage()->getCreatedAt();
}
public function setUpdatedAt(\DateTime $updatedAt = null)
{
$this->getPage()->setUpdatedAt($updatedAt);
}
public function getUpdatedAt()
{
return $this->getPage()->getUpdatedAt();
}
public function isDynamic()
{
return $this->getPage()->isDynamic();
}
public function isCms()
{
return $this->getPage()->isCms();
}
public function isInternal()
{
return $this->getPage()->isInternal();
}
public function hasRequestMethod($method)
{
return $this->getPage()->hasRequestMethod($method);
}
public function setSite(SiteInterface $site)
{
$this->getPage()->setSite($site);
}
public function getSite()
{
return $this->getPage()->getSite();
}
public function setRawHeaders($headers)
{
$this->getPage()->setRawHeaders($headers);
}
public function getEdited()
{
return $this->getPage()->getEdited();
}
public function setEdited($edited)
{
$this->getPage()->setEdited($edited);
}
public function isError()
{
return $this->getPage()->isError();
}
public function getTitle()
{
return $this->getPage()->getTitle();
}
public function setTitle($title)
{
$this->getPage()->setTitle($title);
}
public function setType($type)
{
$this->getPage()->setType($type);
}
public function getType()
{
return $this->getPage()->getType();
}
public function __toString()
{
return $this->getPage()->__toString();
}
public function serialize()
{
if ($this->manager) {
return serialize(array('pageId'=> $this->getPage()->getId(),'snapshotId'=> $this->snapshot->getId(),
));
}
return serialize(array());
}
public function unserialize($serialized)
{
}
}
}
namespace Sonata\PageBundle\Request
{
interface SiteRequestInterface
{
public function setPathInfo($pathInfo);
public function setBaseUrl($baseUrl);
}
}
namespace Sonata\PageBundle\Request
{
use Symfony\Component\HttpFoundation\Request as BaseRequest;
class SiteRequest extends BaseRequest implements SiteRequestInterface
{
public function setPathInfo($pathInfo)
{
$this->pathInfo = $pathInfo;
}
public function setBaseUrl($baseUrl)
{
$this->baseUrl = $baseUrl;
}
}
}
namespace Sonata\PageBundle\Site
{
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
class HostSiteSelector extends BaseSiteSelector
{
public function handleKernelRequest(GetResponseEvent $event)
{
foreach ($this->getSites($event->getRequest()) as $site) {
if (!$site->isEnabled()) {
continue;
}
$this->site = $site;
if (!$this->site->isLocalhost()) {
break;
}
}
if ($this->site && $this->site->getLocale()) {
$event->getRequest()->attributes->set('_locale', $this->site->getLocale());
}
}
}
}
namespace Sonata\MediaBundle\CDN
{
use Aws\CloudFront\CloudFrontClient;
use Aws\CloudFront\Exception\CloudFrontException;
class CloudFront implements CDNInterface
{
protected $path;
protected $key;
protected $secret;
protected $distributionId;
protected $client;
public function __construct($path, $key, $secret, $distributionId)
{
$this->path = $path;
$this->key = $key;
$this->secret = $secret;
$this->distributionId = $distributionId;
}
public function getPath($relativePath, $isFlushable = false)
{
return sprintf('%s/%s', rtrim($this->path,'/'), ltrim($relativePath,'/'));
}
public function flushByString($string)
{
return $this->flushPaths(array($string));
}
public function flush($string)
{
return $this->flushPaths(array($string));
}
public function flushPaths(array $paths)
{
if (empty($paths)) {
throw new \RuntimeException('Unable to flush : expected at least one path');
}
$normalizedPaths = array_map(function($path) {
return'/'. ltrim($path,'/');
}, $paths);
try {
$result = $this->getClient()->createInvalidation(array('DistributionId'=> $this->distributionId,'Paths'=> array('Quantity'=> count($normalizedPaths),'Items'=> $normalizedPaths
),'CallerReference'=> $this->getCallerReference($normalizedPaths),
));
if (!in_array($status = $result->get('Status'), array('Completed','InProgress'))) {
throw new \RuntimeException('Unable to flush : '. $status);
}
return $result->get('Id');
} catch (CloudFrontException $ex) {
throw new \RuntimeException('Unable to flush : '. $ex->getMessage());
}
}
private function getClient()
{
if (!$this->client) {
$this->client = CloudFrontClient::factory(array('key'=> $this->key,'secret'=> $this->secret
));
}
return $this->client;
}
public function setClient($client)
{
$this->client = $client;
}
protected function getCallerReference(array $paths)
{
sort($paths);
return md5(implode(',', $paths));
}
public function getFlushStatus($identifier)
{
try {
$result = $this->getClient()->getInvalidation(array('DistributionId'=> $this->distributionId,'Id'=> $identifier
));
return array_search($result->get('Status'), self::getStatusList());
} catch (CloudFrontException $ex) {
throw new \RuntimeException('Unable to retrieve flush status : '. $ex->getMessage());
}
}
public static function getStatusList()
{
return array(
self::STATUS_OK =>'Completed',
self::STATUS_TO_SEND =>'STATUS_TO_SEND',
self::STATUS_TO_FLUSH =>'STATUS_TO_FLUSH',
self::STATUS_ERROR =>'STATUS_ERROR',
self::STATUS_WAITING =>'InProgress',
);
}
}
}
namespace Sonata\MediaBundle\CDN
{
class Fallback implements CDNInterface
{
protected $cdn;
protected $fallback;
public function __construct(CDNInterface $cdn, CDNInterface $fallback)
{
$this->cdn = $cdn;
$this->fallback = $fallback;
}
public function getPath($relativePath, $isFlushable)
{
if ($isFlushable) {
return $this->fallback->getPath($relativePath, $isFlushable);
}
return $this->cdn->getPath($relativePath, $isFlushable);
}
public function flushByString($string)
{
return $this->cdn->flushByString($string);
}
public function flush($string)
{
return $this->cdn->flush($string);
}
public function flushPaths(array $paths)
{
return $this->cdn->flushPaths($paths);
}
public function getFlushStatus($identifier)
{
return $this->cdn->getFlushStatus($identifier);
}
}
}
namespace Sonata\MediaBundle\CDN
{
class PantherPortal implements CDNInterface
{
protected $path;
protected $username;
protected $password;
protected $siteId;
protected $client;
protected $wsdl;
public function __construct($path, $username, $password, $siteId, $wsdl ="https://pantherportal.cdnetworks.com/wsdl/flush.wsdl")
{
$this->path = $path;
$this->username = $username;
$this->password = $password;
$this->siteId = $siteId;
$this->wsdl = $wsdl;
}
public function getPath($relativePath, $isFlushable)
{
return sprintf('%s/%s', $this->path, $relativePath);
}
public function flushByString($string)
{
$this->flushPaths(array($string));
}
public function flush($string)
{
$this->flushPaths(array($string));
}
public function flushPaths(array $paths)
{
$result = $this->getClient()->flush($this->username, $this->password,"paths", $this->siteId, implode("\n", $paths), true, false);
if ($result !="Flush successfully submitted.") {
throw new \RuntimeException('Unable to flush : '. $result);
}
}
private function getClient()
{
if (!$this->client) {
$this->client = new \SoapClient($this->wsdl);
}
return $this->client;
}
public function setClient($client)
{
$this->client = $client;
}
public function getFlushStatus($identifier)
{
}
}
}
namespace Gaufrette\Adapter
{
interface MetadataSupporter
{
public function setMetadata($key, $content);
public function getMetadata($key);
}
}
namespace Sonata\MediaBundle\Filesystem
{
use Gaufrette\Adapter as AdapterInterface;
use Gaufrette\Adapter\MetadataSupporter;
use Gaufrette\Filesystem;
use Psr\Log\LoggerInterface;
class Replicate implements AdapterInterface, MetadataSupporter
{
protected $master;
protected $slave;
protected $logger;
public function __construct(AdapterInterface $master, AdapterInterface $slave, LoggerInterface $logger = null)
{
$this->master = $master;
$this->slave = $slave;
$this->logger = $logger;
}
public function delete($key)
{
$ok = true;
try {
$this->slave->delete($key);
} catch (\Exception $e) {
if ($this->logger) {
$this->logger->critical(sprintf("Unable to delete %s, error: %s", $key, $e->getMessage()));
}
$ok = false;
}
try {
$this->master->delete($key);
} catch (\Exception $e) {
if ($this->logger) {
$this->logger->critical(sprintf("Unable to delete %s, error: %s", $key, $e->getMessage()));
}
$ok = false;
}
return $ok;
}
public function mtime($key)
{
return $this->master->mtime($key);
}
public function keys()
{
return $this->master->keys();
}
public function exists($key)
{
return $this->master->exists($key);
}
public function write($key, $content, array $metadata = null)
{
$ok = true;
$return = false;
try {
$return = $this->master->write($key, $content, $metadata);
} catch (\Exception $e) {
if ($this->logger) {
$this->logger->critical(sprintf("Unable to write %s, error: %s", $key, $e->getMessage()));
}
$ok = false;
}
try {
$return = $this->slave->write($key, $content, $metadata);
} catch (\Exception $e) {
if ($this->logger) {
$this->logger->critical(sprintf("Unable to write %s, error: %s", $key, $e->getMessage()));
}
$ok = false;
}
return $ok && $return;
}
public function read($key)
{
return $this->master->read($key);
}
public function rename($key, $new)
{
$ok = true;
try {
$this->master->rename($key, $new);
} catch (\Exception $e) {
if ($this->logger) {
$this->logger->critical(sprintf("Unable to rename %s, error: %s", $key, $e->getMessage()));
}
$ok = false;
}
try {
$this->slave->rename($key, $new);
} catch (\Exception $e) {
if ($this->logger) {
$this->logger->critical(sprintf("Unable to rename %s, error: %s", $key, $e->getMessage()));
}
$ok = false;
}
return $ok;
}
public function supportsMetadata()
{
return $this->master instanceof MetadataSupporter || $this->slave instanceof MetadataSupporter;
}
public function setMetadata($key, $metadata)
{
if ($this->master instanceof MetadataSupporter) {
$this->master->setMetadata($key, $metadata);
}
if ($this->slave instanceof MetadataSupporter) {
$this->slave->setMetadata($key, $metadata);
}
}
public function getMetadata($key)
{
if ($this->master instanceof MetadataSupporter) {
return $this->master->getMetadata($key);
} elseif ($this->slave instanceof MetadataSupporter) {
return $this->slave->getMetadata($key);
}
return array();
}
public function getAdapterClassNames()
{
return array(
get_class($this->master),
get_class($this->slave),
);
}
public function createFile($key, Filesystem $filesystem)
{
return $this->master->createFile($key, $filesystem);
}
public function createFileStream($key, Filesystem $filesystem)
{
return $this->master->createFileStream($key, $filesystem);
}
public function listDirectory($directory ='')
{
return $this->master->listDirectory($directory);
}
public function isDirectory($key)
{
return $this->master->isDirectory($key);
}
}
}
namespace Sonata\MediaBundle\Generator
{
use Sonata\MediaBundle\Model\MediaInterface;
class ODMGenerator implements GeneratorInterface
{
public function generatePath(MediaInterface $media)
{
$id = $media->getId();
return sprintf('%s/%04s/%02s', $media->getContext(), substr($id, 0, 4), substr($id, 4, 2));
}
}
}
namespace Sonata\MediaBundle\Generator
{
use Sonata\MediaBundle\Model\MediaInterface;
class PHPCRGenerator implements GeneratorInterface
{
public function generatePath(MediaInterface $media)
{
$segments = preg_split('#/#', $media->getId(), null, PREG_SPLIT_NO_EMPTY);
if (count($segments) > 1) {
array_pop($segments);
$path = join($segments,'/');
} else {
$path ='';
}
return $path ? sprintf('%s/%s', $media->getContext(), $path) : $media->getContext();
}
}
}
namespace Sonata\MediaBundle\Model
{
abstract class GalleryManager implements GalleryManagerInterface
{
public function create()
{
$class = $this->getClass();
return new $class;
}
}
}
namespace Sonata\MediaBundle\Security
{
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
class SessionDownloadStrategy implements DownloadStrategyInterface
{
protected $container;
protected $translator;
protected $times;
protected $sessionKey ='sonata/media/session/times';
public function __construct(TranslatorInterface $translator, ContainerInterface $container, $times)
{
$this->times = $times;
$this->container = $container;
$this->translator = $translator;
}
public function isGranted(MediaInterface $media, Request $request)
{
if (!$this->container->has('session')) {
return false;
}
$times = $this->getSession()->get($this->sessionKey, 0);
if ($times >= $this->times) {
return false;
}
$times++;
$this->getSession()->set($this->sessionKey, $times);
return true;
}
public function getDescription()
{
return $this->translator->trans('description.session_download_strategy', array('%times%'=> $this->times),'SonataMediaBundle');
}
private function getSession()
{
return $this->container->get('session');
}
}
}
namespace Sonata\MediaBundle\Templating\Helper
{
use Symfony\Component\Templating\Helper\Helper;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\Templating\EngineInterface;
class MediaHelper extends Helper
{
protected $pool = null;
protected $templating = null;
public function __construct(Pool $pool, EngineInterface $templating)
{
$this->pool = $pool;
$this->templating = $templating;
}
public function getName()
{
return'sonata_media';
}
public function media($media, $format, $options = array())
{
if (!$media) {
return'';
}
$provider = $this->getProvider($media);
$format = $provider->getFormatName($media, $format);
$options = $provider->getHelperProperties($media, $format, $options);
return $this->templating->render($provider->getTemplate('helper_view'), array('media'=> $media,'format'=> $format,'options'=> $options,
));
}
private function getProvider(MediaInterface $media)
{
return $this->pool->getProvider($media->getProviderName());
}
public function thumbnail($media, $format, $options = array())
{
if (!$media) {
return'';
}
$provider = $this->getProvider($media);
$format = $provider->getFormatName($media, $format);
$formatDefinition = $provider->getFormat($format);
$options = array_merge(array('title'=> $media->getName(),'width'=> $formatDefinition['width'],
), $options);
$options['src'] = $provider->generatePublicUrl($media, $format);
return $this->getTemplating()->render($provider->getTemplate('helper_thumbnail'), array('media'=> $media,'options'=> $options,
));
}
public function path($media, $format)
{
if (!$media) {
return'';
}
$provider = $this->getProvider($media);
$format = $provider->getFormatName($media, $format);
return $provider->generatePublicUrl($media, $format);
}
}
}
namespace
{
interface Twig_NodeInterface extends Countable, IteratorAggregate
{
public function compile(Twig_Compiler $compiler);
public function getLine();
public function getNodeTag();
}
}
namespace
{
class Twig_Node implements Twig_NodeInterface
{
protected $nodes;
protected $attributes;
protected $lineno;
protected $tag;
public function __construct(array $nodes = array(), array $attributes = array(), $lineno = 0, $tag = null)
{
$this->nodes = $nodes;
$this->attributes = $attributes;
$this->lineno = $lineno;
$this->tag = $tag;
}
public function __toString()
{
$attributes = array();
foreach ($this->attributes as $name => $value) {
$attributes[] = sprintf('%s: %s', $name, str_replace("\n",'', var_export($value, true)));
}
$repr = array(get_class($this).'('.implode(', ', $attributes));
if (count($this->nodes)) {
foreach ($this->nodes as $name => $node) {
$len = strlen($name) + 4;
$noderepr = array();
foreach (explode("\n", (string) $node) as $line) {
$noderepr[] = str_repeat(' ', $len).$line;
}
$repr[] = sprintf('  %s: %s', $name, ltrim(implode("\n", $noderepr)));
}
$repr[] =')';
} else {
$repr[0] .=')';
}
return implode("\n", $repr);
}
public function toXml($asDom = false)
{
$dom = new DOMDocument('1.0','UTF-8');
$dom->formatOutput = true;
$dom->appendChild($xml = $dom->createElement('twig'));
$xml->appendChild($node = $dom->createElement('node'));
$node->setAttribute('class', get_class($this));
foreach ($this->attributes as $name => $value) {
$node->appendChild($attribute = $dom->createElement('attribute'));
$attribute->setAttribute('name', $name);
$attribute->appendChild($dom->createTextNode($value));
}
foreach ($this->nodes as $name => $n) {
if (null === $n) {
continue;
}
$child = $n->toXml(true)->getElementsByTagName('node')->item(0);
$child = $dom->importNode($child, true);
$child->setAttribute('name', $name);
$node->appendChild($child);
}
return $asDom ? $dom : $dom->saveXml();
}
public function compile(Twig_Compiler $compiler)
{
foreach ($this->nodes as $node) {
$node->compile($compiler);
}
}
public function getLine()
{
return $this->lineno;
}
public function getNodeTag()
{
return $this->tag;
}
public function hasAttribute($name)
{
return array_key_exists($name, $this->attributes);
}
public function getAttribute($name)
{
if (!array_key_exists($name, $this->attributes)) {
throw new LogicException(sprintf('Attribute "%s" does not exist for Node "%s".', $name, get_class($this)));
}
return $this->attributes[$name];
}
public function setAttribute($name, $value)
{
$this->attributes[$name] = $value;
}
public function removeAttribute($name)
{
unset($this->attributes[$name]);
}
public function hasNode($name)
{
return array_key_exists($name, $this->nodes);
}
public function getNode($name)
{
if (!array_key_exists($name, $this->nodes)) {
throw new LogicException(sprintf('Node "%s" does not exist for Node "%s".', $name, get_class($this)));
}
return $this->nodes[$name];
}
public function setNode($name, $node = null)
{
$this->nodes[$name] = $node;
}
public function removeNode($name)
{
unset($this->nodes[$name]);
}
public function count()
{
return count($this->nodes);
}
public function getIterator()
{
return new ArrayIterator($this->nodes);
}
}
}
namespace Sonata\MediaBundle\Twig\Node
{
class MediaNode extends \Twig_Node
{
protected $extensionName;
public function __construct($extensionName, \Twig_Node_Expression $media, \Twig_Node_Expression $format, \Twig_Node_Expression $attributes, $lineno, $tag = null)
{
$this->extensionName = $extensionName;
parent::__construct(array('media'=> $media,'format'=> $format,'attributes'=> $attributes), array(), $lineno, $tag);
}
public function compile(\Twig_Compiler $compiler)
{
$compiler
->addDebugInfo($this)
->write(sprintf("echo \$this->env->getExtension('%s')->media(", $this->extensionName))
->subcompile($this->getNode('media'))
->raw(', ')
->subcompile($this->getNode('format'))
->raw(', ')
->subcompile($this->getNode('attributes'))
->raw(");\n")
;
}
}
}
namespace Sonata\MediaBundle\Twig\Node
{
class PathNode extends \Twig_Node
{
protected $extensionName;
public function __construct($extensionName, \Twig_Node_Expression $media, \Twig_Node_Expression $format, $lineno, $tag = null)
{
$this->extensionName = $extensionName;
parent::__construct(array('media'=> $media,'format'=> $format), array(), $lineno, $tag);
}
public function compile(\Twig_Compiler $compiler)
{
$compiler
->addDebugInfo($this)
->write(sprintf("echo \$this->env->getExtension('%s')->path(", $this->extensionName))
->subcompile($this->getNode('media'))
->raw(', ')
->subcompile($this->getNode('format'))
->raw(");\n")
;
}
}
}
namespace Sonata\MediaBundle\Twig\Node
{
class ThumbnailNode extends \Twig_Node
{
protected $extensionName;
public function __construct($extensionName, \Twig_Node_Expression $media, \Twig_Node_Expression $format, \Twig_Node_Expression $attributes, $lineno, $tag = null)
{
$this->extensionName = $extensionName;
parent::__construct(array('media'=> $media,'format'=> $format,'attributes'=> $attributes), array(), $lineno, $tag);
}
public function compile(\Twig_Compiler $compiler)
{
$compiler
->addDebugInfo($this)
->write(sprintf("echo \$this->env->getExtension('%s')->thumbnail(", $this->extensionName))
->subcompile($this->getNode('media'))
->raw(', ')
->subcompile($this->getNode('format'))
->raw(', ')
->subcompile($this->getNode('attributes'))
->raw(");\n")
;
}
}
}
namespace Sonata\AdminBundle\Admin
{
class FieldDescriptionCollection implements \ArrayAccess, \Countable
{
protected $elements = array();
public function add(FieldDescriptionInterface $fieldDescription)
{
$this->elements[$fieldDescription->getName()] = $fieldDescription;
}
public function getElements()
{
return $this->elements;
}
public function has($name)
{
return array_key_exists($name, $this->elements);
}
public function get($name)
{
if ($this->has($name)) {
return $this->elements[$name];
}
throw new \InvalidArgumentException(sprintf('Element "%s" does not exist.', $name));
}
public function remove($name)
{
if ($this->has($name)) {
unset($this->elements[$name]);
}
}
public function offsetExists($offset)
{
return $this->has($offset);
}
public function offsetGet($offset)
{
return $this->get($offset);
}
public function offsetSet($offset, $value)
{
throw new \RunTimeException('Cannot set value, use add');
}
public function offsetUnset($offset)
{
$this->remove($offset);
}
public function count()
{
return count($this->elements);
}
public function reorder(array $keys)
{
if ($this->has('batch')) {
array_unshift($keys,'batch');
}
$this->elements = array_merge(array_flip($keys), $this->elements);
}
}
}
namespace Sonata\AdminBundle\Datagrid
{
use Sonata\AdminBundle\Filter\FilterInterface;
interface DatagridInterface
{
public function getPager();
public function getQuery();
public function getResults();
public function buildPager();
public function addFilter(FilterInterface $filter);
public function getFilters();
public function reorderFilters(array $keys);
public function getValues();
public function getColumns();
public function setValue($name, $operator, $value);
public function getForm();
public function getFilter($name);
public function hasFilter($name);
public function removeFilter($name);
public function hasActiveFilters();
public function hasDisplayableFilters();
}
}
namespace Sonata\AdminBundle\Datagrid
{
use Sonata\AdminBundle\Filter\FilterInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionCollection;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
class Datagrid implements DatagridInterface
{
protected $filters = array();
protected $values;
protected $columns;
protected $pager;
protected $bound = false;
protected $query;
protected $formBuilder;
protected $form;
protected $results;
public function __construct(ProxyQueryInterface $query, FieldDescriptionCollection $columns, PagerInterface $pager, FormBuilderInterface $formBuilder, array $values = array())
{
$this->pager = $pager;
$this->query = $query;
$this->values = $values;
$this->columns = $columns;
$this->formBuilder = $formBuilder;
}
public function getPager()
{
return $this->pager;
}
public function getResults()
{
$this->buildPager();
if (!$this->results) {
$this->results = $this->pager->getResults();
}
return $this->results;
}
public function buildPager()
{
if ($this->bound) {
return;
}
foreach ($this->getFilters() as $name => $filter) {
list($type, $options) = $filter->getRenderSettings();
$this->formBuilder->add($filter->getFormName(), $type, $options);
}
$this->formBuilder->add('_sort_by','hidden');
$this->formBuilder->get('_sort_by')->addViewTransformer(new CallbackTransformer(
function ($value) { return $value; },
function ($value) { return $value instanceof FieldDescriptionInterface ? $value->getName() : $value; }
));
$this->formBuilder->add('_sort_order','hidden');
$this->formBuilder->add('_page','hidden');
$this->formBuilder->add('_per_page','hidden');
$this->form = $this->formBuilder->getForm();
$this->form->submit($this->values);
$data = $this->form->getData();
foreach ($this->getFilters() as $name => $filter) {
$this->values[$name] = isset($this->values[$name]) ? $this->values[$name] : null;
$filter->apply($this->query, $data[$filter->getFormName()]);
}
if (isset($this->values['_sort_by'])) {
if (!$this->values['_sort_by'] instanceof FieldDescriptionInterface) {
throw new UnexpectedTypeException($this->values['_sort_by'],'FieldDescriptionInterface');
}
if ($this->values['_sort_by']->isSortable()) {
$this->query->setSortBy($this->values['_sort_by']->getSortParentAssociationMapping(), $this->values['_sort_by']->getSortFieldMapping());
$this->query->setSortOrder(isset($this->values['_sort_order']) ? $this->values['_sort_order'] : null);
}
}
$maxPerPage = 25;
if (isset($this->values['_per_page'])) {
if (is_array($this->values['_per_page'])) {
if (isset($this->values['_per_page']['value'])) {
$maxPerPage = $this->values['_per_page']['value'];
}
} else {
$maxPerPage = $this->values['_per_page'];
}
}
$this->pager->setMaxPerPage($maxPerPage);
$page = 1;
if (isset($this->values['_page'])) {
if (is_array($this->values['_page'])) {
if (isset($this->values['_page']['value'])) {
$page = $this->values['_page']['value'];
}
} else {
$page = $this->values['_page'];
}
}
$this->pager->setPage($page);
$this->pager->setQuery($this->query);
$this->pager->init();
$this->bound = true;
}
public function addFilter(FilterInterface $filter)
{
$this->filters[$filter->getName()] = $filter;
}
public function hasFilter($name)
{
return isset($this->filters[$name]);
}
public function removeFilter($name)
{
unset($this->filters[$name]);
}
public function getFilter($name)
{
return $this->hasFilter($name) ? $this->filters[$name] : null;
}
public function getFilters()
{
return $this->filters;
}
public function reorderFilters(array $keys)
{
$this->filters = array_merge(array_flip($keys), $this->filters);
}
public function getValues()
{
return $this->values;
}
public function setValue($name, $operator, $value)
{
$this->values[$name] = array('type'=> $operator,'value'=> $value,
);
}
public function hasActiveFilters()
{
foreach ($this->filters as $name => $filter) {
if ($filter->isActive()) {
return true;
}
}
return false;
}
public function hasDisplayableFilters()
{
foreach ($this->filters as $name => $filter) {
$showFilter = $filter->getOption('show_filter', null);
if (($filter->isActive() && $showFilter === null) || ($showFilter === true)) {
return true;
}
}
return false;
}
public function getColumns()
{
return $this->columns;
}
public function getQuery()
{
return $this->query;
}
public function getForm()
{
$this->buildPager();
return $this->form;
}
}
}
namespace Sonata\AdminBundle\Mapper
{
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Builder\BuilderInterface;
abstract class BaseMapper
{
protected $admin;
protected $builder;
public function __construct(BuilderInterface $builder, AdminInterface $admin)
{
$this->builder = $builder;
$this->admin = $admin;
}
public function getAdmin()
{
return $this->admin;
}
abstract public function get($key);
abstract public function has($key);
abstract public function remove($key);
abstract public function reorder(array $keys);
}
}
namespace Sonata\AdminBundle\Datagrid
{
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Builder\DatagridBuilderInterface;
use Sonata\AdminBundle\Mapper\BaseMapper;
class DatagridMapper extends BaseMapper
{
protected $datagrid;
public function __construct(DatagridBuilderInterface $datagridBuilder, DatagridInterface $datagrid, AdminInterface $admin)
{
parent::__construct($datagridBuilder, $admin);
$this->datagrid = $datagrid;
}
public function add($name, $type = null, array $filterOptions = array(), $fieldType = null, $fieldOptions = null, array $fieldDescriptionOptions = array())
{
if (is_array($fieldOptions)) {
$filterOptions['field_options'] = $fieldOptions;
}
if ($fieldType) {
$filterOptions['field_type'] = $fieldType;
}
if ($name instanceof FieldDescriptionInterface) {
$fieldDescription = $name;
$fieldDescription->mergeOptions($filterOptions);
} elseif (is_string($name)) {
if ($this->admin->hasFilterFieldDescription($name)) {
throw new \RuntimeException(sprintf('Duplicate field name "%s" in datagrid mapper. Names should be unique.', $name));
}
if (!isset($filterOptions['field_name'])) {
$filterOptions['field_name'] = substr(strrchr('.'.$name,'.'), 1);
}
$fieldDescription = $this->admin->getModelManager()->getNewFieldDescriptionInstance(
$this->admin->getClass(),
$name,
array_merge($filterOptions, $fieldDescriptionOptions)
);
} else {
throw new \RuntimeException('Unknown field name in datagrid mapper. Field name should be either of FieldDescriptionInterface interface or string.');
}
$this->builder->addFilter($this->datagrid, $type, $fieldDescription, $this->admin);
return $this;
}
public function get($name)
{
return $this->datagrid->getFilter($name);
}
public function has($key)
{
return $this->datagrid->hasFilter($key);
}
public function remove($key)
{
$this->admin->removeFilterFieldDescription($key);
$this->datagrid->removeFilter($key);
return $this;
}
public function reorder(array $keys)
{
$this->datagrid->reorderFilters($keys);
return $this;
}
}
}
namespace Sonata\AdminBundle\Datagrid
{
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionCollection;
use Sonata\AdminBundle\Builder\ListBuilderInterface;
use Sonata\AdminBundle\Mapper\BaseMapper;
class ListMapper extends BaseMapper
{
protected $list;
public function __construct(ListBuilderInterface $listBuilder, FieldDescriptionCollection $list, AdminInterface $admin)
{
parent::__construct($listBuilder, $admin);
$this->list = $list;
}
public function addIdentifier($name, $type = null, array $fieldDescriptionOptions = array())
{
$fieldDescriptionOptions['identifier'] = true;
if (!isset($fieldDescriptionOptions['route']['name'])) {
$routeName = ($this->admin->isGranted('EDIT') && $this->admin->hasRoute('edit')) ?'edit':'show';
$fieldDescriptionOptions['route']['name'] = $routeName;
}
if (!isset($fieldDescriptionOptions['route']['parameters'])) {
$fieldDescriptionOptions['route']['parameters'] = array();
}
return $this->add($name, $type, $fieldDescriptionOptions);
}
public function add($name, $type = null, array $fieldDescriptionOptions = array())
{
if ($name =='_action'&& $type =='actions') {
if (isset($fieldDescriptionOptions['actions']['view'])) {
trigger_error('Inline action "view" is deprecated since version 2.2.4. Use inline action "show" instead.', E_USER_DEPRECATED);
$fieldDescriptionOptions['actions']['show'] = $fieldDescriptionOptions['actions']['view'];
unset($fieldDescriptionOptions['actions']['view']);
}
}
if (in_array($type, array('actions','batch','select'))) {
$fieldDescriptionOptions['virtual_field'] = true;
}
if ($name instanceof FieldDescriptionInterface) {
$fieldDescription = $name;
$fieldDescription->mergeOptions($fieldDescriptionOptions);
} elseif (is_string($name)) {
if ($this->admin->hasListFieldDescription($name)) {
throw new \RuntimeException(sprintf('Duplicate field name "%s" in list mapper. Names should be unique.', $name));
}
$fieldDescription = $this->admin->getModelManager()->getNewFieldDescriptionInstance(
$this->admin->getClass(),
$name,
$fieldDescriptionOptions
);
} else {
throw new \RuntimeException('Unknown field name in list mapper. Field name should be either of FieldDescriptionInterface interface or string.');
}
if (!$fieldDescription->getLabel()) {
$fieldDescription->setOption('label', $this->admin->getLabelTranslatorStrategy()->getLabel($fieldDescription->getName(),'list','label'));
}
$this->builder->addField($this->list, $type, $fieldDescription, $this->admin);
return $this;
}
public function get($name)
{
return $this->list->get($name);
}
public function has($key)
{
return $this->list->has($key);
}
public function remove($key)
{
$this->admin->removeListFieldDescription($key);
$this->list->remove($key);
return $this;
}
public function reorder(array $keys)
{
$this->list->reorder($keys);
return $this;
}
}
}
namespace Sonata\AdminBundle\Datagrid
{
interface ProxyQueryInterface
{
public function execute(array $params = array(), $hydrationMode = null);
public function __call($name, $args);
public function setSortBy($parentAssociationMappings, $fieldMapping);
public function getSortBy();
public function setSortOrder($sortOrder);
public function getSortOrder();
public function getSingleScalarResult();
public function setFirstResult($firstResult);
public function getFirstResult();
public function setMaxResults($maxResults);
public function getMaxResults();
public function getUniqueParameterId();
public function entityJoin(array $associationMappings);
}
}
namespace Sonata\AdminBundle\Exception
{
class ModelManagerException extends \Exception
{
}
}
namespace Sonata\AdminBundle\Exception
{
class NoValueException extends \Exception
{
}
}
namespace Symfony\Component\Form\Extension\Core\ChoiceList
{
interface ChoiceListInterface
{
public function getChoices();
public function getValues();
public function getPreferredViews();
public function getRemainingViews();
public function getChoicesForValues(array $values);
public function getValuesForChoices(array $choices);
public function getIndicesForChoices(array $choices);
public function getIndicesForValues(array $values);
}
}
namespace Symfony\Component\Form\Extension\Core\ChoiceList
{
use Symfony\Component\Form\FormConfigBuilder;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\View\ChoiceView;
class ChoiceList implements ChoiceListInterface
{
protected $choices = array();
protected $values = array();
private $preferredViews = array();
private $remainingViews = array();
public function __construct($choices, array $labels, array $preferredChoices = array())
{
if (!is_array($choices) && !$choices instanceof \Traversable) {
throw new UnexpectedTypeException($choices,'array or \Traversable');
}
$this->initialize($choices, $labels, $preferredChoices);
}
protected function initialize($choices, array $labels, array $preferredChoices)
{
$this->choices = array();
$this->values = array();
$this->preferredViews = array();
$this->remainingViews = array();
$this->addChoices(
$this->preferredViews,
$this->remainingViews,
$choices,
$labels,
$preferredChoices
);
}
public function getChoices()
{
return $this->choices;
}
public function getValues()
{
return $this->values;
}
public function getPreferredViews()
{
return $this->preferredViews;
}
public function getRemainingViews()
{
return $this->remainingViews;
}
public function getChoicesForValues(array $values)
{
$values = $this->fixValues($values);
$choices = array();
foreach ($values as $i => $givenValue) {
foreach ($this->values as $j => $value) {
if ($value === $givenValue) {
$choices[$i] = $this->choices[$j];
unset($values[$i]);
if (0 === count($values)) {
break 2;
}
}
}
}
return $choices;
}
public function getValuesForChoices(array $choices)
{
$choices = $this->fixChoices($choices);
$values = array();
foreach ($choices as $i => $givenChoice) {
foreach ($this->choices as $j => $choice) {
if ($choice === $givenChoice) {
$values[$i] = $this->values[$j];
unset($choices[$i]);
if (0 === count($choices)) {
break 2;
}
}
}
}
return $values;
}
public function getIndicesForChoices(array $choices)
{
$choices = $this->fixChoices($choices);
$indices = array();
foreach ($choices as $i => $givenChoice) {
foreach ($this->choices as $j => $choice) {
if ($choice === $givenChoice) {
$indices[$i] = $j;
unset($choices[$i]);
if (0 === count($choices)) {
break 2;
}
}
}
}
return $indices;
}
public function getIndicesForValues(array $values)
{
$values = $this->fixValues($values);
$indices = array();
foreach ($values as $i => $givenValue) {
foreach ($this->values as $j => $value) {
if ($value === $givenValue) {
$indices[$i] = $j;
unset($values[$i]);
if (0 === count($values)) {
break 2;
}
}
}
}
return $indices;
}
protected function addChoices(array &$bucketForPreferred, array &$bucketForRemaining, $choices, array $labels, array $preferredChoices)
{
foreach ($choices as $group => $choice) {
if (!array_key_exists($group, $labels)) {
throw new InvalidArgumentException('The structures of the choices and labels array do not match.');
}
if (is_array($choice)) {
if (count($choice) > 0) {
$this->addChoiceGroup(
$group,
$bucketForPreferred,
$bucketForRemaining,
$choice,
$labels[$group],
$preferredChoices
);
}
} else {
$this->addChoice(
$bucketForPreferred,
$bucketForRemaining,
$choice,
$labels[$group],
$preferredChoices
);
}
}
}
protected function addChoiceGroup($group, array &$bucketForPreferred, array &$bucketForRemaining, array $choices, array $labels, array $preferredChoices)
{
$bucketForPreferred[$group] = array();
$bucketForRemaining[$group] = array();
$this->addChoices(
$bucketForPreferred[$group],
$bucketForRemaining[$group],
$choices,
$labels,
$preferredChoices
);
if (empty($bucketForPreferred[$group])) {
unset($bucketForPreferred[$group]);
}
if (empty($bucketForRemaining[$group])) {
unset($bucketForRemaining[$group]);
}
}
protected function addChoice(array &$bucketForPreferred, array &$bucketForRemaining, $choice, $label, array $preferredChoices)
{
$index = $this->createIndex($choice);
if (''=== $index || null === $index || !FormConfigBuilder::isValidName((string) $index)) {
throw new InvalidConfigurationException(sprintf('The index "%s" created by the choice list is invalid. It should be a valid, non-empty Form name.', $index));
}
$value = $this->createValue($choice);
if (!is_string($value)) {
throw new InvalidConfigurationException(sprintf('The value created by the choice list is of type "%s", but should be a string.', gettype($value)));
}
$view = new ChoiceView($choice, $value, $label);
$this->choices[$index] = $this->fixChoice($choice);
$this->values[$index] = $value;
if ($this->isPreferred($choice, $preferredChoices)) {
$bucketForPreferred[$index] = $view;
} else {
$bucketForRemaining[$index] = $view;
}
}
protected function isPreferred($choice, array $preferredChoices)
{
return in_array($choice, $preferredChoices, true);
}
protected function createIndex($choice)
{
return count($this->choices);
}
protected function createValue($choice)
{
return (string) count($this->values);
}
protected function fixValue($value)
{
return (string) $value;
}
protected function fixValues(array $values)
{
foreach ($values as $i => $value) {
$values[$i] = $this->fixValue($value);
}
return $values;
}
protected function fixIndex($index)
{
if (is_bool($index) || (string) (int) $index === (string) $index) {
return (int) $index;
}
return (string) $index;
}
protected function fixIndices(array $indices)
{
foreach ($indices as $i => $index) {
$indices[$i] = $this->fixIndex($index);
}
return $indices;
}
protected function fixChoice($choice)
{
return $choice;
}
protected function fixChoices(array $choices)
{
return $choices;
}
}
}
namespace Symfony\Component\Form\Extension\Core\ChoiceList
{
class SimpleChoiceList extends ChoiceList
{
public function __construct(array $choices, array $preferredChoices = array())
{
parent::__construct($choices, $choices, array_flip($preferredChoices));
}
public function getChoicesForValues(array $values)
{
$values = $this->fixValues($values);
return $this->fixChoices(array_intersect($values, $this->getValues()));
}
public function getValuesForChoices(array $choices)
{
$choices = $this->fixChoices($choices);
return $this->fixValues(array_intersect($choices, $this->getValues()));
}
protected function addChoices(array &$bucketForPreferred, array &$bucketForRemaining, $choices, array $labels, array $preferredChoices)
{
foreach ($choices as $choice => $label) {
if (is_array($label)) {
if (count($label) > 0) {
$this->addChoiceGroup(
$choice,
$bucketForPreferred,
$bucketForRemaining,
$label,
$label,
$preferredChoices
);
}
} else {
$this->addChoice(
$bucketForPreferred,
$bucketForRemaining,
$choice,
$label,
$preferredChoices
);
}
}
}
protected function isPreferred($choice, array $preferredChoices)
{
return isset($preferredChoices[$choice]);
}
protected function fixChoice($choice)
{
return $this->fixIndex($choice);
}
protected function fixChoices(array $choices)
{
return $this->fixIndices($choices);
}
protected function createValue($choice)
{
return (string) $choice;
}
}
}
namespace Sonata\AdminBundle\Form\ChoiceList
{
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Sonata\AdminBundle\Model\ModelManagerInterface;
class ModelChoiceList extends SimpleChoiceList
{
private $modelManager;
private $class;
private $entities = array();
private $query;
private $identifier = array();
private $reflProperties = array();
private $propertyPath;
public function __construct(ModelManagerInterface $modelManager, $class, $property = null, $query = null, $choices = array())
{
$this->modelManager = $modelManager;
$this->class = $class;
$this->query = $query;
$this->identifier = $this->modelManager->getIdentifierFieldNames($this->class);
if ($property) {
$this->propertyPath = new PropertyPath($property);
}
parent::__construct($this->load($choices));
}
protected function load($choices)
{
if (is_array($choices)) {
$entities = $choices;
} elseif ($this->query) {
$entities = $this->modelManager->executeQuery($this->query);
} else {
$entities = $this->modelManager->findBy($this->class);
}
$choices = array();
$this->entities = array();
foreach ($entities as $key => $entity) {
if ($this->propertyPath) {
$propertyAccessor = PropertyAccess::createPropertyAccessor();
$value = $propertyAccessor->getValue($entity, $this->propertyPath);
} else {
try {
$value = (string) $entity;
} catch (\Exception $e) {
throw new RuntimeException(sprintf("Unable to convert the entity %s to String, entity must have a '__toString()' method defined", ClassUtils::getClass($entity)), 0, $e);
}
}
if (count($this->identifier) > 1) {
$choices[$key] = $value;
$this->entities[$key] = $entity;
} else {
$id = current($this->getIdentifierValues($entity));
$choices[$id] = $value;
$this->entities[$id] = $entity;
}
}
return $choices;
}
public function getIdentifier()
{
return $this->identifier;
}
public function getEntities()
{
return $this->entities;
}
public function getEntity($key)
{
if (count($this->identifier) > 1) {
$entities = $this->getEntities();
return isset($entities[$key]) ? $entities[$key] : null;
} elseif ($this->entities) {
return isset($this->entities[$key]) ? $this->entities[$key] : null;
}
return $this->modelManager->find($this->class, $key);
}
private function getReflProperty($property)
{
if (!isset($this->reflProperties[$property])) {
$this->reflProperties[$property] = new \ReflectionProperty($this->class, $property);
$this->reflProperties[$property]->setAccessible(true);
}
return $this->reflProperties[$property];
}
public function getIdentifierValues($entity)
{
try {
return $this->modelManager->getIdentifierValues($entity);
} catch (\Exception $e) {
throw new InvalidArgumentException(sprintf("Unable to retrieve the identifier values for entity %s", ClassUtils::getClass($entity)), 0, $e);
}
}
public function getModelManager()
{
return $this->modelManager;
}
public function getClass()
{
return $this->class;
}
}
}
namespace Sonata\AdminBundle\Form\DataTransformer
{
use Symfony\Component\Form\DataTransformerInterface;
use Sonata\AdminBundle\Model\ModelManagerInterface;
class ArrayToModelTransformer implements DataTransformerInterface
{
protected $modelManager;
protected $className;
public function __construct(ModelManagerInterface $modelManager, $className)
{
$this->modelManager = $modelManager;
$this->className = $className;
}
public function reverseTransform($array)
{
if ($array instanceof $this->className) {
return $array;
}
$instance = new $this->className;
if (!is_array($array)) {
return $instance;
}
return $this->modelManager->modelReverseTransform($this->className, $array);
}
public function transform($value)
{
return $value;
}
}
}
namespace Sonata\AdminBundle\Form\DataTransformer
{
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\DataTransformerInterface;
use Sonata\AdminBundle\Form\ChoiceList\ModelChoiceList;
class ModelsToArrayTransformer implements DataTransformerInterface
{
protected $choiceList;
public function __construct(ModelChoiceList $choiceList)
{
$this->choiceList = $choiceList;
}
public function transform($collection)
{
if (null === $collection) {
return array();
}
$array = array();
if (count($this->choiceList->getIdentifier()) > 1) {
$availableEntities = $this->choiceList->getEntities();
foreach ($collection as $entity) {
$key = array_search($entity, $availableEntities);
$array[] = $key;
}
} else {
foreach ($collection as $entity) {
$array[] = current($this->choiceList->getIdentifierValues($entity));
}
}
return $array;
}
public function reverseTransform($keys)
{
$collection = $this->choiceList->getModelManager()->getModelCollectionInstance(
$this->choiceList->getClass()
);
if (!$collection instanceof \ArrayAccess) {
throw new UnexpectedTypeException($collection,'\ArrayAccess');
}
if (''=== $keys || null === $keys) {
return $collection;
}
if (!is_array($keys)) {
throw new UnexpectedTypeException($keys,'array');
}
$notFound = array();
foreach ($keys as $key) {
if ($entity = $this->choiceList->getEntity($key)) {
$collection[] = $entity;
} else {
$notFound[] = $key;
}
}
if (count($notFound) > 0) {
throw new TransformationFailedException(sprintf('The entities with keys "%s" could not be found', implode('", "', $notFound)));
}
return $collection;
}
}
}
namespace Sonata\AdminBundle\Form\DataTransformer
{
use Symfony\Component\Form\DataTransformerInterface;
use Sonata\AdminBundle\Model\ModelManagerInterface;
class ModelToIdTransformer implements DataTransformerInterface
{
protected $modelManager;
protected $className;
public function __construct(ModelManagerInterface $modelManager, $className)
{
$this->modelManager = $modelManager;
$this->className = $className;
}
public function reverseTransform($newId)
{
if (empty($newId) && !in_array($newId, array("0", 0), true)) {
return null;
}
return $this->modelManager->find($this->className, $newId);
}
public function transform($entity)
{
if (empty($entity)) {
return null;
}
return $this->modelManager->getNormalizedIdentifier($entity);
}
}
}
namespace Sonata\AdminBundle\Form\EventListener
{
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Sonata\AdminBundle\Model\ModelManagerInterface;
class MergeCollectionListener implements EventSubscriberInterface
{
protected $modelManager;
public function __construct(ModelManagerInterface $modelManager)
{
$this->modelManager = $modelManager;
}
public static function getSubscribedEvents()
{
return array(
FormEvents::SUBMIT => array('onBind', 10),
);
}
public function onBind(FormEvent $event)
{
$collection = $event->getForm()->getData();
$data = $event->getData();
$event->stopPropagation();
if (!$collection) {
$collection = $data;
} elseif (count($data) === 0) {
$this->modelManager->collectionClear($collection);
} else {
foreach ($collection as $entity) {
if (!$this->modelManager->collectionHasElement($data, $entity)) {
$this->modelManager->collectionRemoveElement($collection, $entity);
} else {
$this->modelManager->collectionRemoveElement($data, $entity);
}
}
foreach ($data as $entity) {
$this->modelManager->collectionAddElement($collection, $entity);
}
}
$event->setData($collection);
}
}
}
namespace Sonata\AdminBundle\Mapper
{
abstract class BaseGroupedMapper extends BaseMapper
{
protected $currentGroup;
protected $currentTab;
protected $apply;
abstract protected function getGroups();
abstract protected function getTabs();
abstract protected function setGroups(array $groups);
abstract protected function setTabs(array $tabs);
public function with($name, array $options = array())
{
$defaultOptions = array('collapsed'=> false,'class'=> false,'description'=> false,'translation_domain'=> null,'name'=> $name,'box_class'=>'box box-primary',
);
$code = $name;
if (array_key_exists('tab', $options) && $options['tab']) {
$tabs = $this->getTabs();
if ($this->currentTab) {
if (isset($tabs[$this->currentTab]['auto_created']) && true === $tabs[$this->currentTab]['auto_created']) {
throw new \RuntimeException('New tab was added automatically when you have added field or group. You should close current tab before adding new one OR add tabs before adding groups and fields.');
} else {
throw new \RuntimeException(sprintf('You should close previous tab "%s" with end() before adding new tab "%s".', $this->currentTab, $name));
}
} elseif ($this->currentGroup) {
throw new \RuntimeException(sprintf('You should open tab before adding new group "%s".', $name));
}
if (!isset($tabs[$name])) {
$tabs[$name] = array();
}
$tabs[$code] = array_merge($defaultOptions, array('auto_created'=> false,'groups'=> array(),
), $tabs[$code], $options);
$this->currentTab = $code;
} else {
if ($this->currentGroup) {
throw new \RuntimeException(sprintf('You should close previous group "%s" with end() before adding new tab "%s".', $this->currentGroup, $name));
}
if (!$this->currentTab) {
$this->with('default', array('tab'=> true,'auto_created'=> true,'translation_domain'=> isset($options['translation_domain']) ? $options['translation_domain'] : null
)); }
if ($this->currentTab !=='default') {
$code = $this->currentTab.'.'.$name; }
$groups = $this->getGroups();
if (!isset($groups[$code])) {
$groups[$code] = array();
}
$groups[$code] = array_merge($defaultOptions, array('fields'=> array(),
), $groups[$code], $options);
$this->currentGroup = $code;
$this->setGroups($groups);
$tabs = $this->getTabs();
}
if ($this->currentGroup && isset($tabs[$this->currentTab]) && !in_array($this->currentGroup, $tabs[$this->currentTab]['groups'])) {
$tabs[$this->currentTab]['groups'][] = $this->currentGroup;
}
$this->setTabs($tabs);
return $this;
}
public function ifTrue($bool)
{
if ($this->apply !== null) {
throw new \RuntimeException('Cannot nest ifTrue or ifFalse call');
}
$this->apply = ($bool === true);
return $this;
}
public function ifFalse($bool)
{
if ($this->apply !== null) {
throw new \RuntimeException('Cannot nest ifTrue or ifFalse call');
}
$this->apply = ($bool === false);
return $this;
}
public function ifEnd()
{
$this->apply = null;
return $this;
}
public function tab($name, array $options = array())
{
return $this->with($name, array_merge($options, array('tab'=> true)));
}
public function end()
{
if ($this->currentGroup !== null) {
$this->currentGroup = null;
} elseif ($this->currentTab !== null) {
$this->currentTab = null;
} else {
throw new \RuntimeException('No open tabs or groups, you cannot use end()');
}
return $this;
}
public function hasOpenTab()
{
return null !== $this->currentTab;
}
protected function addFieldToCurrentGroup($fieldName)
{
$currentGroup = $this->getCurrentGroupName();
$groups = $this->getGroups();
$groups[$currentGroup]['fields'][$fieldName] = $fieldName;
$this->setGroups($groups);
return $groups[$currentGroup];
}
protected function getCurrentGroupName()
{
if (!$this->currentGroup) {
$this->with($this->admin->getLabel(), array('auto_created'=> true));
}
return $this->currentGroup;
}
}
}
namespace Sonata\AdminBundle\Form
{
use Sonata\AdminBundle\Builder\FormContractorInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Mapper\BaseGroupedMapper;
use Symfony\Component\Form\FormBuilderInterface;
class FormMapper extends BaseGroupedMapper
{
protected $formBuilder;
public function __construct(FormContractorInterface $formContractor, FormBuilderInterface $formBuilder, AdminInterface $admin)
{
parent::__construct($formContractor, $admin);
$this->formBuilder = $formBuilder;
}
public function reorder(array $keys)
{
$this->admin->reorderFormGroup($this->getCurrentGroupName(), $keys);
return $this;
}
public function add($name, $type = null, array $options = array(), array $fieldDescriptionOptions = array())
{
if ($this->apply !== null && !$this->apply) {
return $this;
}
if ($name instanceof FormBuilderInterface) {
$fieldName = $name->getName();
} else {
$fieldName = $name;
}
if (!$name instanceof FormBuilderInterface && strpos($fieldName,'.')!==false && !isset($options['property_path'])) {
$options['property_path'] = $fieldName;
$fieldName = str_replace('.','__', $fieldName);
}
if ($type =='collection') {
$type ='sonata_type_native_collection';
}
$label = $fieldName;
$group = $this->addFieldToCurrentGroup($label);
if (!isset($fieldDescriptionOptions['type']) && is_string($type)) {
$fieldDescriptionOptions['type'] = $type;
}
if ($group['translation_domain'] && !isset($fieldDescriptionOptions['translation_domain'])) {
$fieldDescriptionOptions['translation_domain'] = $group['translation_domain'];
}
$fieldDescription = $this->admin->getModelManager()->getNewFieldDescriptionInstance(
$this->admin->getClass(),
$name instanceof FormBuilderInterface ? $name->getName() : $name,
$fieldDescriptionOptions
);
$this->builder->fixFieldDescription($this->admin, $fieldDescription, $fieldDescriptionOptions);
if ($fieldName != $name) {
$fieldDescription->setName($fieldName);
}
$this->admin->addFormFieldDescription($fieldName, $fieldDescription);
if ($name instanceof FormBuilderInterface) {
$this->formBuilder->add($name);
} else {
$options = array_replace_recursive($this->builder->getDefaultOptions($type, $fieldDescription), $options);
if (!isset($options['label_render'])) {
$options['label_render'] = false;
}
if (!isset($options['label'])) {
$options['label'] = $this->admin->getLabelTranslatorStrategy()->getLabel($fieldDescription->getName(),'form','label');
}
$help = null;
if (isset($options['help'])) {
$help = $options['help'];
unset($options['help']);
}
$this->formBuilder->add($fieldDescription->getName(), $type, $options);
if (null !== $help) {
$this->admin->getFormFieldDescription($fieldDescription->getName())->setHelp($help);
}
}
return $this;
}
public function get($name)
{
return $this->formBuilder->get($name);
}
public function has($key)
{
return $this->formBuilder->has($key);
}
public function remove($key)
{
$this->admin->removeFormFieldDescription($key);
$this->admin->removeFieldFromFormGroup($key);
$this->formBuilder->remove($key);
return $this;
}
public function getFormBuilder()
{
return $this->formBuilder;
}
public function create($name, $type = null, array $options = array())
{
return $this->formBuilder->create($name, $type, $options);
}
public function setHelps(array $helps = array())
{
foreach ($helps as $name => $help) {
if ($this->admin->hasFormFieldDescription($name)) {
$this->admin->getFormFieldDescription($name)->setHelp($help);
}
}
return $this;
}
protected function getGroups()
{
return $this->admin->getFormGroups();
}
protected function setGroups(array $groups)
{
$this->admin->setFormGroups($groups);
}
protected function getTabs()
{
return $this->admin->getFormTabs();
}
protected function setTabs(array $tabs)
{
$this->admin->setFormTabs($tabs);
}
}
}
namespace Sonata\AdminBundle\Security\Handler
{
use Sonata\AdminBundle\Admin\AdminInterface;
class NoopSecurityHandler implements SecurityHandlerInterface
{
public function isGranted(AdminInterface $admin, $attributes, $object = null)
{
return true;
}
public function getBaseRole(AdminInterface $admin)
{
return'';
}
public function buildSecurityInformation(AdminInterface $admin)
{
return array();
}
public function createObjectSecurity(AdminInterface $admin, $object)
{
}
public function deleteObjectSecurity(AdminInterface $admin, $object)
{
}
}
}
namespace Sonata\AdminBundle\Security\Handler
{
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Sonata\AdminBundle\Admin\AdminInterface;
class RoleSecurityHandler implements SecurityHandlerInterface
{
protected $authorizationChecker;
protected $superAdminRoles;
public function __construct($authorizationChecker, array $superAdminRoles)
{
if (!$authorizationChecker instanceof AuthorizationCheckerInterface && !$authorizationChecker instanceof SecurityContextInterface) {
throw new \InvalidArgumentException('Argument 1 should be an instance of Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface or Symfony\Component\Security\Core\SecurityContextInterface');
}
$this->authorizationChecker = $authorizationChecker;
$this->superAdminRoles = $superAdminRoles;
}
public function isGranted(AdminInterface $admin, $attributes, $object = null)
{
if (!is_array($attributes)) {
$attributes = array($attributes);
}
foreach ($attributes as $pos => $attribute) {
$attributes[$pos] = sprintf($this->getBaseRole($admin), $attribute);
}
try {
return $this->authorizationChecker->isGranted($this->superAdminRoles)
|| $this->authorizationChecker->isGranted($attributes, $object);
} catch (AuthenticationCredentialsNotFoundException $e) {
return false;
} catch (\Exception $e) {
throw $e;
}
}
public function getBaseRole(AdminInterface $admin)
{
return'ROLE_'. str_replace('.','_', strtoupper($admin->getCode())) .'_%s';
}
public function buildSecurityInformation(AdminInterface $admin)
{
return array();
}
public function createObjectSecurity(AdminInterface $admin, $object)
{
}
public function deleteObjectSecurity(AdminInterface $admin, $object)
{
}
}
}
namespace Sonata\AdminBundle\Show
{
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionCollection;
use Sonata\AdminBundle\Builder\ShowBuilderInterface;
use Sonata\AdminBundle\Mapper\BaseGroupedMapper;
class ShowMapper extends BaseGroupedMapper
{
protected $list;
public function __construct(ShowBuilderInterface $showBuilder, FieldDescriptionCollection $list, AdminInterface $admin)
{
parent::__construct($showBuilder, $admin);
$this->list = $list;
}
public function add($name, $type = null, array $fieldDescriptionOptions = array())
{
if ($this->apply !== null && !$this->apply) {
return $this;
}
$fieldKey = ($name instanceof FieldDescriptionInterface) ? $name->getName() : $name;
$this->addFieldToCurrentGroup($fieldKey);
if ($name instanceof FieldDescriptionInterface) {
$fieldDescription = $name;
$fieldDescription->mergeOptions($fieldDescriptionOptions);
} elseif (is_string($name) && !$this->admin->hasShowFieldDescription($name)) {
$fieldDescription = $this->admin->getModelManager()->getNewFieldDescriptionInstance(
$this->admin->getClass(),
$name,
$fieldDescriptionOptions
);
} else {
throw new \RuntimeException('invalid state');
}
if (!$fieldDescription->getLabel()) {
$fieldDescription->setOption('label', $this->admin->getLabelTranslatorStrategy()->getLabel($fieldDescription->getName(),'show','label'));
}
$fieldDescription->setOption('safe', $fieldDescription->getOption('safe', false));
$this->builder->addField($this->list, $type, $fieldDescription, $this->admin);
return $this;
}
public function get($name)
{
return $this->list->get($name);
}
public function has($key)
{
return $this->list->has($key);
}
public function remove($key)
{
$this->admin->removeShowFieldDescription($key);
$this->list->remove($key);
return $this;
}
public function reorder(array $keys)
{
$this->admin->reorderShowGroup($this->getCurrentGroupName(), $keys);
return $this;
}
protected function getGroups()
{
return $this->admin->getShowGroups();
}
protected function setGroups(array $groups)
{
$this->admin->setShowGroups($groups);
}
protected function getTabs()
{
return $this->admin->getShowTabs();
}
protected function setTabs(array $tabs)
{
$this->admin->setShowTabs($tabs);
}
}
}
namespace Sonata\AdminBundle\Util
{
use Symfony\Component\Form\FormBuilderInterface;
class FormBuilderIterator extends \RecursiveArrayIterator
{
protected static $reflection;
protected $formBuilder;
protected $keys = array();
protected $prefix;
protected $iterator;
public function __construct(FormBuilderInterface $formBuilder, $prefix = false)
{
$this->formBuilder = $formBuilder;
$this->prefix = $prefix ? $prefix : $formBuilder->getName();
$this->iterator = new \ArrayIterator(self::getKeys($formBuilder));
}
private static function getKeys(FormBuilderInterface $formBuilder)
{
if (!self::$reflection) {
self::$reflection = new \ReflectionProperty(get_class($formBuilder),'children');
self::$reflection->setAccessible(true);
}
return array_keys(self::$reflection->getValue($formBuilder));
}
public function rewind()
{
$this->iterator->rewind();
}
public function valid()
{
return $this->iterator->valid();
}
public function key()
{
$name = $this->iterator->current();
return sprintf('%s_%s', $this->prefix, $name);
}
public function next()
{
$this->iterator->next();
}
public function current()
{
return $this->formBuilder->get($this->iterator->current());
}
public function getChildren()
{
return new self($this->formBuilder->get($this->iterator->current()), $this->current());
}
public function hasChildren()
{
return count(self::getKeys($this->current())) > 0;
}
}
}
namespace Sonata\AdminBundle\Util
{
use Symfony\Component\Form\FormView;
class FormViewIterator implements \RecursiveIterator
{
protected $formView;
protected $iterator;
public function __construct(FormView $formView)
{
$this->iterator = $formView->getIterator();
}
public function getChildren()
{
return new FormViewIterator($this->current());
}
public function hasChildren()
{
return count($this->current()->children) > 0;
}
public function current()
{
return $this->iterator->current();
}
public function next()
{
$this->iterator->next();
}
public function key()
{
return $this->current()->vars['id'];
}
public function valid()
{
return $this->iterator->valid();
}
public function rewind()
{
$this->iterator->rewind();
}
}
}
namespace Sonata\BlockBundle\Exception
{
interface BlockExceptionInterface
{
}
}
namespace Sonata\BlockBundle\Exception
{
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class BlockNotFoundException extends NotFoundHttpException
{
}
}
namespace Sonata\BlockBundle\Model
{
class Block extends BaseBlock
{
protected $id;
public function setId($id)
{
$this->id = $id;
}
public function getId()
{
return $this->id;
}
}
}
namespace Sonata\BlockBundle\Model
{
use Sonata\BlockBundle\Model\Block;
class EmptyBlock extends Block
{
}
}