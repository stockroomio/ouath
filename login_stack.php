




<!DOCTYPE HTML>
<html lang="en">
<head> 
<title> Javascript SDK  - Stack Exchange API</title>
<link rel="stylesheet" href="https://cdn.sstatic.net/apiv2/all.css?v=c94591bdf97e">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(function(){
            var scriptLoc = 'https://api.stackexchange.com/js/2.0/all.js';

            if (window.location.protocol == "https:" ) {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = scriptLoc;

                document.getElementsByTagName('head')[0].appendChild(script)
            }else{
                window.SE = { init: function(){}, authenticate: function(){} };
            }
        });
    </script>

    <script type="text/javascript" src="https://cdn.sstatic.net/apiv2/js/prettify.js?v=38e736b8e1ab"></script>

</head>
<body>
    <div class="intro">
        <div class="wrapper">
            <a href="/" class="logo">Stack Exchange</a>
        
            <div class="nav">
                <ul>
                    <li><a href="/docs">Documentation</a></li>
                </ul>
            </div>
        </div>
        <br style="clear: both;" />
    </div>

    <div class="content">
        <div class="wrapper">
            <div class="mainbar">
            


<h2>Discussion</h2>
<div class="indented">
    <p>For simple client-side authentication, we provide a minimal Javascript library hosted by Stack Exchange.  To add this library to your site,
    add:
    </p>
            
    <pre class="prettyprint"><code>&lt;script type=&#39;text/javascript&#39; src=&#39;https://api.stackexchange.com/js/2.0/all.js&#39;&gt;&lt;/script&gt;</code></pre>

    <p>Your application must have the client side OAuth flow enabled, and must not have the desktop application redirect uri disabled.  Both
    of these settings are available on an applications edit page.</p>
</div>

<h2>Usage</h2>
<div class="indented">
    <p>The Stack Exchange provided javascript library is intentionally small and minimalistic.  If you're looking for simple client side authentication it
    will probably meet your needs, for more <a href="http://stackapps.com/questions/tagged/library+javascript">fully featured libraries see Stack Apps</a>.</p>

    <p>While this library's flow is mostly standard OAuth 2.0, there are a few non-standard behaviors to enable cross-domain communication.  Code that
    relies on those behaviors not documented as part of the standard <a href="/docs/authentication">authentication flow</a> should not be incorporated 
    into applications or libraries, these are considered implementation details and may be changed at any time.</p>
        

    <h3>Initialization</h3>
    <div class="indented">
        <p>Initialize the library prior to making any other calls with a call to <code>SE.init(options)</code></p>

        <pre class="prettyprint"><code>&lt;script type=&#39;text/javascript&#39;&gt;
SE.init({
    clientId: 1,
    key: &#39;123456&#39;,
    channelUrl: &#39;http://example.com/blank&#39;,
    complete: function (data) { ... }
});
&lt;/script&gt;</code></pre>

        <p>These options are all required:
            <ul>
                <li><strong>clientId</strong> &ndash; an application's client id, as indicated on the application edit page</li>
                <li><strong>key</strong> &ndash; an application's request key, as indicated on the application edit page</li>
                <li><strong>channelUrl</strong> &ndash; a blank page under the same domain as the including page.</li>
                <li><strong>complete</strong> &ndash; a function(data) that will be called when initialization is complete</li>
            </ul>
        </p>

        <div>
            <p><strong>channelUrl</strong> is used for cross-domain communication in older browsers, and should be a completely blank, fast loading page.</p>
        </div>

        <div>
            <p><strong>complete</strong> will lose any special blessings with regards to being able to open windows or similar.<br>
            <br>
            An object is passed of the form:</p>
            <pre class="prettyprint"><code>{ version: &#39;some-unique-string&#39; }</code></pre>

            <p><em>version</em> is provided for bug reporting purposes, few client's will use it during normal operation.</p>
        </div>
    </div>

    <h3>Authentication</h3>
    <div class="indented">
        <p>Get an access token for (and optionally the identity of) a user with a call to <code>SE.authenticate(options)</code>.  
        This method should only be called in response to user action (like clicking a button), lest the popup window created as 
        a result be hidden by the user's browser.</p>

        <pre class="prettyprint"><code>&lt;script type=&#39;text/javascript&#39;&gt;
SE.authenticate({
    success: function(data) { ... },
    error: function(data) { ... },
    scope: [&#39;read_inbox&#39;],
    networkUsers: true
});
&lt;/script&gt;</code></pre>

        <p>Valid options are:
            <ul>
                <li><strong>success</strong> (required) &ndash; a function(data) that is called upon a successful authentication</li>
                <li><strong>error</strong> (optional) &ndash; a function(data) that is called upon a failed authentication</li>
                <li><strong>scope</strong> (optional) &ndash; an array of scopes to request during authentication, valid scopes are in the <a href="/docs/authentication">authentication documentaiton</a>.</li>
                <li><strong>networkUsers</strong> (optional) &ndash; if present and true, a user's associated users will be passed to success.</li>
            </ul>
        </p>

        <div>
            <p><strong>success</strong> is called with an object of the form:</p>
            <pre class="prettyprint"><code>{ accessToken: &#39;12345&#39;,
expirationDate: new Date(...),
networkUsers: [...] }</code></pre>

            <p>If a scope of <code>no_expiry</code> was requested, <em>expirationDate</em> will not be set.</p>

            <p>If <strong>networkUsers</strong> was not passed to <code>SE.authenticate</code> <em>networkUsers</em> will not bet set, if set it is an array of <a href="/docs/types/network-user">network_user objects</a>.</p>
        </div>

        <div>
            <p><strong>error</strong> is called with an object of the form:</p>
            <pre class="prettyprint"><code>{ errorName: &#39;access_denied&#39;,
errorMessage: &#39;the unicorns are not amused&#39; }</code></pre>

            <p>Possible errors encountered during authentication are <a href="/docs/authentication">documented here</a>, while those encountered during subsequent data fetches are <a href="/docs/error-handling">documented here</a>.</p>

            <p>Of special note, a user denying access to their account via the Reject button will result in <strong>error</strong> being called with an <em>errorName</em> of "access_denied".</p>

            <p>Be aware that there is no guarantee that either <strong>success</strong> or <strong>error</strong> will be called as a result of calling <code>SE.authenticate(...)</code>.  A user could close the popup window, navigate
            away, or otherwise interrupt the authentication process in ways that cannot be gracefully reported.</p>
        </div>
    </div>
</div>

<h2>Example</h2>
<div class="indented">


    <div>
<pre class="prettyprint"><code>&lt;script type=&#39;text/javascript&#39;&gt;
// For simplicity, we&#39;re using jQuery for some things
//   However, the library has no jQuery dependency
$(function(){
// Initialize library
SE.init({ 
    // Parameters obtained by registering an app, these are specific to the SE
    //   documentation site
    clientId: 1, 
    key: &#39;U4DMV*8nvpm3EOpvf69Rxw((&#39;, 
    // Used for cross domain communication, it will be validated
    channelUrl: &#39;https://api.stackexchange.com/docs/proxy&#39;,
    // Called when all initialization is finished
    complete: function(data) { 
        $(&#39;#login-button&#39;)
            .removeAttr(&#39;disabled&#39;)
            .text(&#39;Run Example With Version &#39;+data.version); 
    }
});

// Attach click handler to login button
$(&#39;#login-button&#39;).click(function() {

    // Make the authentication call, note that being in an onclick handler
    //   is important; most browsers will hide windows opened without a
    //   &#39;click blessing&#39;
    SE.authenticate({
        success: function(data) { 
            alert(
                &#39;User Authorized with account id = &#39; + 
                data.networkUsers[0].account_id + &#39;, got access token = &#39; + 
                data.accessToken
            ); 
        },
        error: function(data) { 
            alert(&#39;An error occurred:\n&#39; + data.errorName + &#39;\n&#39; + data.errorMessage); 
        },
        networkUsers: true
    });
});
});
&lt;/script&gt;
</code></pre>
    </div>

    <script type="text/javascript">
    var loadInterval;
        
    loadInterval =
    setInterval(
        function(){ 
            if(!window.SE) return;
            
// For simplicity, we're using jQuery for some things
//   However, the library has no jQuery dependency
$(function(){
// Initialize library
SE.init({ 
    // Parameters obtained by registering an app, these are specific to the SE
    //   documentation site
    clientId: 1, 
    key: 'U4DMV*8nvpm3EOpvf69Rxw((', 
    // Used for cross domain communication, it will be validated
    channelUrl: 'https://api.stackexchange.com/docs/proxy',
    // Called when all initialization is finished
    complete: function(data) { 
        $('#login-button')
            .removeAttr('disabled')
            .text('Run Example With Version '+data.version); 
    }
});

// Attach click handler to login button
$('#login-button').click(function() {

    // Make the authentication call, note that being in an onclick handler
    //   is important; most browsers will hide windows opened without a
    //   'click blessing'
    SE.authenticate({
        success: function(data) { 
            alert(
                'User Authorized with account id = ' + 
                data.networkUsers[0].account_id + ', got access token = ' + 
                data.accessToken
            ); 
        },
        error: function(data) { 
            alert('An error occurred:\n' + data.errorName + '\n' + data.errorMessage); 
        },
        networkUsers: true
    });
});
});

            clearInterval(loadInterval);
        },
        100
    );
    </script>

    <div>
        <button id="login-button" disabled>Loading...</button>
    </div>
</div>
            </div>
            

<div class="sidebar">
    <div class="module help">
        <ul>
            <li><a href="/docs/authentication">Authentication</a></li>
            <li><a href="/docs/js-lib" class="youarehere">Javascript SDK</a></li>
            <li class="list-separator"></li>
            <li><a href="/docs/vectors">Batching Requests</a></li>
            <li><a href="/docs/min-max">Complex Queries</a></li>
            <li><a href="/docs/duplicate-requests">Duplicate Requests</a></li>
            <li><a href="/docs/filters">Filters</a></li>
            <li><a href="/docs/paging">Paging</a></li>
            <li class="list-separator"></li>
            <li><a href="/docs/dates">Dates</a></li>
            <li><a href="/docs/numbers">Numbers</a></li>
            <li class="list-separator"></li>
            <li><a href="/docs/compression">Compression</a></li>
            <li><a href="/docs/error-handling">Error Handling</a></li>
            <li><a href="/docs/wrapper">Response Wrapper</a></li>
            <li><a href="/docs/throttle">Rate Limiting</a></li>
            <li><a href="/docs/user-types">Users</a></li>
            <li class="list-separator"></li>
            <li><a href="/docs/write">Write</a></li>
            <li class="list-separator"></li>
            <li><a href="/docs/change-log">Change Log</a></li>
            <li class="list-separator"></li>
            <li><a href="http://stackexchange.com/legal/api-terms-of-use">Terms Of Use</a></li>
        </ul>
    </div>
</div>
            <br style="clear: both;" />
        </div>
        
        <div class="bottom">
            <div class="bottom-wrapper">
                
            </div>
        </div>
    </div>

    <div class="footer">
    <div class="wrapper">
        <p class="footer-links"><a href="http://stackexchange.com/about">about</a> <a href="http://blog.stackexchange.com">blog</a> <a href="http://stackexchange.com/legal/api-terms-of-use">terms of use</a> <a href="mailto:team+api@stackexchange.com">contact us</a> <a href="http://stackapps.com/">feedback always welcome</a></p>
        <p style="margin-bottom: 0;">site design / logo &copy; 2015 stack exchange, inc; user contributions licensed under <a href="http://creativecommons.org/licenses/by-sa/3.0/" rel="license">cc by-sa 3.0</a> with <a href="http://blog.stackoverflow.com/2009/06/attribution-required/" rel="license">attribution required</a></p>
    </div>
    <br style="clear: both;" />
</div>
</body>
</html>