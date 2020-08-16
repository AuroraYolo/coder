## 请求处理器
```
HTTP 请求处理器是任何一个 web 项目中的基本部分，服务器端的代码接受请求消息，然后处理它，并且生成一个响应信息。HTTP 中间件就是一种将处理请求和响应过程从应用层分离出来的方法。

这个接口在本片文章中的描述将会是抽象的请求处理器和中间件。
```

## 请求处理器
```
请求处理器必须是独立的组件来处理请求和创建由 PSR-7 定义的结果响应。

如果请求的条件组织请求处理器产生相应，那么请求处理器 应该 抛出一个异常。这个异常的类型是没有定义的。

使用该标准的中间件 必须 实现以下接口：

Psr\Http\Server\RequestHandlerInterface
```

## 中间件
```
中间件组件是一个独立组件，通常与其他中间件组件一起参与处理传入请求并创建由 PSR-7 定义的结果响应

如果条件条件充分，中间件组件 应该 创建并返回响应而不委托给请求处理程序。

使用该标准的中间件 必须 实现以下接口：

Psr\Http\Server\MiddlewareInterface
```
## 生成响应
```
建议任何生成响应的中间件或请求处理程序将组成 PSR-7ResponseInterface 的原型或能够生成 ResponseInterface 实例的工厂，以防止依赖于特定的 HTTP 消息实现。
```
##  异常处理
```
建议任何使用中间件的应用程序都包含捕获异常并将其转换为响应的组件。 这个中间件应该是第一个被执行的组件，并且包含所有进一步的处理以确保始终生成响应
```

## Psr\Http\Server\RequestHandlerInterface
```
namespace Psr\Http\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * 处理服务器请求并返回响应
 *
 * HTTP 请求处理程序处理 HTTP 请求，以便生成 HTTP 相应。
 */
interface RequestHandlerInterface
{
    /**
     * 处理服务器请求并返回响应
     *
     * 可以调用其他协助代码来生成响应。
     */
    public function handle(ServerRequestInterface $request): ResponseInterface;
}
```

## Psr\Http\Server\MiddlewareInterface
```
namespace Psr\Http\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * 参与处理服务器的请求与响应
 *
 * 一个 HTTP 中间件组件参与处理一个 HTTP 的消息:
 * 通过对请求进行操作, 生成相应,或者将请求转发给后续的中间件，并  且可能对它的响应进行操作
 * 
 */
interface MiddlewareInterface
{
    /**
     * 处理一个传入的请求
     *
     * 处理传入的服务器请求以产生相应.
     * 如果无法生成响应本身，它可能会委托给提供的请求处理程序来执行此操作
     * 
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface;
}
```




