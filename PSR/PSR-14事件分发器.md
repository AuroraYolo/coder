## 事件分发器
```
事件 - 事件是发射器生成的消息。它可以是任意的 PHP 对象。
监听器 - 一个监听器是任意的可调用的 PHP 类或函数，它期待着事件的传递。相同的事件可以传递给零个或多个监听器。如果有必要，一个监听器可以入队一些其他的异步行为。
发射器 - 发射器是期待分发事件的任何 PHP 代码，也叫调用代码。它不是由任何特定的数据结构表示的，而是指用例。
分发器 - 分发器是一个服务对象，它的事件对象由发射器提供。分发器负责将事件传递给所有相关的监听器，但是必须把确定哪些监听器应该响应事件这一步骤委托给监听器提供者去做。
监听器提供者 - 监听器提供者负责确定哪些监听器是与给定事件相关的，但是它不能调用监听器。一个监听器提供者可能会指定零个或多个相关的监听器
```
## 事件
```
事件是充当发射器和适当的监听器之间的通信单元的对象。

如果用例要求监听器提供信息给发射器，那事件对象可能是可变的。然而，如果没有这种双向通信要求，那么建议事件对象定义成不可变的。即，不给对象定义改变对象的方法。

实现者必须假设相同的对象将被传递到所有的监听器。

建议，但不要求事件对象实现无丢失的序列化与反序列化；$event == unserialize(serialize($event))应该为真。如果合适的话，事件对象可以利用 PHP 的 Serializable 接口，__sleep() 或__wakeup() 魔术方法或类似的语言的功能。
```
## 可终止的事件
```
一个可终止的事件是事件的特殊案例，它包含了一些额外的方法，这些方法阻止后继监听器被调用。它是通过实现 StoppableEventInterface 来表示的。

当事件被完成时，实现了 StoppableEventInterface 的事件必须从 isPropagationStopped() 返回真。具体由类的实现者自己决定。比如，一个事件，它请求调用匹配了相应 ResponseInterface 对象的 PSR-7RequestInterface 对象，那它可能有一个 setResponse(ResponseInterface $res) 方法供监听器调用，这方法引起 isPropagationStopped() 返回真。
```
## 监听器
```
一个监听器可以是任何可调用的 PHP 类或函数。监听器必须仅有一个参数，即它响应的事件。监听器应该根据相关用例约束参数类型。就是说，一个监听器可能使用某接口的类型约束，表示它与任何实现了该接口的事件类型兼容，或与该接口的特定实现兼容。

一个监听器应该返回 void，且应该显示约束它。分发器必须忽略从监听器返回的值。

一个监听器可能将操作委托给其他代码。其中包含一个监听器，这个监听器是运行实际业务逻辑对象的浅包装。

一个监听器可能入队来自事件对象的信息，由调度器、队列服务器或者类似的辅助处理程序进行后续处理。它也可能将序列化的事件对象入队。但是，也要考虑到并不是所有的事件对象都可以被安全的序列化。辅助处理程序必须假设对事件对象的任何改变都不会传递给监听器。
```

## 分发器
```
分发器是实现了 EventDispatcherInterface 的服务对象。它负责为已分发的事件从监听器提供者中获取监听器，并调用与该事件相关的每一个监听器。

分发器必须同步按序调用从监听器提供者获得的监听器。
调用完监听器后，必须返回相同的事件对象。
在所有的监听器执行完之前，必不能返回给发射器。
如果传递了可终止的事件，分发器：

必须在每个监听器调用之前调用事件中的方法 isPropagationStopped()。if 过返回为真，必须立刻将事件返回给发射器，且必不能继续调用监听器。这就意味着如果传递给分发器的事件在调用 isPropagationStopped() 后总是返回真，将不会有监听器被调用。
分发器应该假设从监听器提供者获取的监听器都是类型安全的。就是说，分发器应该假设调用 $listener($event) 不会产生 TypeError
```
## 错误处理
```
有监听器触发异常或者错误必须阻塞后续监听器的执行。监听器触发的异常或错误必须允许回传到发射器。

分发器可能会记录捕获的异常或错误，及其他操作，但是操作完后必须将重新抛回原始的异常或错误。
```

## 监听器提供者
```
监听器提供者负责确定给定事件与哪些监听器相关，哪些监听器应该被调用。它可能既要决定哪些监听器是相关的也要根据给定的意义按序返回监听器。可能包括：

允许某种形式的注册机制，以便实现者可以按固定顺序将监听器分配给事件。
根据事件的类型和实现的接口，通过反射派生出一个适用的监听器列表。
提前生成可能在运行时查询的已编译的监听器列表。
实现某种形式的访问控制，以便只有当前用户具有特定权限时才会调用某些监听器。
从事件引用的对象（如实体）中提取某些信息，并对该对象调用预定义的生命周期方法。
使用某些任意逻辑将其职责委托给一个或多个其他监听器提供程序。
监听器提供者应该根据事件的类名来区分事件。也可能视情况根据事件的其他信息来区分。

在确定监听器的适用性时，监听器提供程序必须将父类型与事件本身的类型同等对待。在以下情况下：

class A {}

class B extends A {}

$b = new B();

function listener(A $event): void {};
监听器提供者必须将 listener() 视为 $b 的可选监听器，因为它是类型兼容的，除非有其他的规则阻住它这样做。

对象合成
分发器应该组成一个监听器提供者来确定相关的监听器。建议将监听器实现为与分发器不同的对象，但这不是要求的。
```
## 接口
```
namespace Psr\EventDispatcher;

/**
 * Defines a dispatcher for events.
 */
interface EventDispatcherInterface
{
    /**
     * Provide all relevant listeners with an event to process.
     *
     * @param object $event
     *   The object to process.
     *
     * @return object
     *   The Event that was passed, now modified by listeners.
     */
    public function dispatch(object $event);
}
namespace Psr\EventDispatcher;

/**
 * Mapper from an event to the listeners that are applicable to that event.
 */
interface ListenerProviderInterface
{
    /**
     * @param object $event
     *   An event for which to return the relevant listeners.
     * @return iterable[callable]
     *   An iterable (array, iterator, or generator) of callables.  Each
     *   callable MUST be type-compatible with $event.
     */
    public function getListenersForEvent(object $event) : iterable;
}
namespace Psr\EventDispatcher;

/**
 * An Event whose processing may be interrupted when the event has been handled.
 *
 * A Dispatcher implementation MUST check to determine if an Event
 * is marked as stopped after each listener is called.  If it is then it should
 * return immediately without calling any further Listeners.
 */
interface StoppableEventInterface
{
    /**
     * Is propagation stopped?
     *
     * This will typically only be used by the Dispatcher to determine if the
     * previous listener halted propagation.
     *
     * @return bool
     *   True if the Event is complete and no further listeners should be called.
     *   False to continue calling listeners.
     */
    public function isPropagationStopped() : bool;
}
```


