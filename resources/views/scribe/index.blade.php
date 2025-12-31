<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.6.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.6.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authentication" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authentication">
                    <a href="#authentication">Authentication</a>
                </li>
                                    <ul id="tocify-subheader-authentication" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="authentication-POSTregister">
                                <a href="#authentication-POSTregister">Register a new user

Creates a new user account.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-GETlogin">
                                <a href="#authentication-GETlogin">Login a user

Logs in a user and returns a JSON token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTlogin">
                                <a href="#authentication-POSTlogin">Login a user

Logs in a user and returns a JSON token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTforgot-password">
                                <a href="#authentication-POSTforgot-password">Reset password

Resets the user's password using the token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-GETreset-password--token-">
                                <a href="#authentication-GETreset-password--token-">Reset password

Resets the user's password using the token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-GETverify-email--id---hash-">
                                <a href="#authentication-GETverify-email--id---hash-">Verify email

Marks the user's email as verified.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTlogout">
                                <a href="#authentication-POSTlogout">Logout a user

Logs out the authenticated user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-GETlogout">
                                <a href="#authentication-GETlogout">Logout a user

Logs out the authenticated user.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-POSTapi-webhook-dojah">
                                <a href="#endpoints-POSTapi-webhook-dojah">POST api/webhook/dojah</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-kyc-webhook">
                                <a href="#endpoints-POSTapi-kyc-webhook">POST api/kyc/webhook</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-ping">
                                <a href="#endpoints-GETapi-ping">GET api/ping</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-loan_payment_reminder">
                                <a href="#endpoints-GETapi-loan_payment_reminder">GET api/loan_payment_reminder</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-auto-process-loans">
                                <a href="#endpoints-GETapi-auto-process-loans">GET api/auto-process-loans</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETregister">
                                <a href="#endpoints-GETregister">Display the registration view.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETforgot-password">
                                <a href="#endpoints-GETforgot-password">Display the password reset link request view.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETget-lgas--state-">
                                <a href="#endpoints-GETget-lgas--state-">GET get-lgas/{state}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETverify-email">
                                <a href="#endpoints-GETverify-email">Display the email verification prompt.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTemail-verification-notification">
                                <a href="#endpoints-POSTemail-verification-notification">Send a new email verification notification.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETconfirm-password">
                                <a href="#endpoints-GETconfirm-password">Show the confirm password view.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTconfirm-password">
                                <a href="#endpoints-POSTconfirm-password">Confirm the user's password.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTpassword">
                                <a href="#endpoints-PUTpassword">Update the user's password.</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: December 31, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_KEY}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your token by visiting your dashboard and clicking <b>Generate API token</b>.</p>

        <h1 id="authentication">Authentication</h1>

    

                                <h2 id="authentication-POSTregister">Register a new user

Creates a new user account.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTregister">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/register" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"architecto\",
    \"email\": \"gbailey@example.net\",
    \"password\": \"|]|{+-\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/register"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "architecto",
    "email": "gbailey@example.net",
    "password": "|]|{+-"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTregister">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;user&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;John Doe&quot;,
        &quot;email&quot;: &quot;user@example.com&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTregister" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTregister"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTregister"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTregister" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTregister">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTregister" data-method="POST"
      data-path="register"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTregister', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTregister"
                    onclick="tryItOut('POSTregister');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTregister"
                    onclick="cancelTryOut('POSTregister');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTregister"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTregister"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTregister"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTregister"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTregister"
               value="architecto"
               data-component="body">
    <br>
<p>The user's name. Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTregister"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>The user's email. Example: <code>gbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTregister"
               value="|]|{+-"
               data-component="body">
    <br>
<p>The user's password. Example: <code>|]|{+-</code></p>
        </div>
        </form>

                    <h2 id="authentication-GETlogin">Login a user

Logs in a user and returns a JSON token.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETlogin">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/login" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"gbailey@example.net\",
    \"password\": \"|]|{+-\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/login"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "gbailey@example.net",
    "password": "|]|{+-"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETlogin">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;token&quot;: &quot;abcdef123456&quot;,
    &quot;user&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;John Doe&quot;,
        &quot;email&quot;: &quot;user@example.com&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETlogin" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETlogin"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETlogin"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETlogin" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETlogin">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETlogin" data-method="GET"
      data-path="login"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETlogin', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETlogin"
                    onclick="tryItOut('GETlogin');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETlogin"
                    onclick="cancelTryOut('GETlogin');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETlogin"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETlogin"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETlogin"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETlogin"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="GETlogin"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>The user's email. Example: <code>gbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="GETlogin"
               value="|]|{+-"
               data-component="body">
    <br>
<p>The user's password. Example: <code>|]|{+-</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTlogin">Login a user

Logs in a user and returns a JSON token.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTlogin">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/login" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"gbailey@example.net\",
    \"password\": \"|]|{+-\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/login"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "gbailey@example.net",
    "password": "|]|{+-"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTlogin">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;token&quot;: &quot;abcdef123456&quot;,
    &quot;user&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;John Doe&quot;,
        &quot;email&quot;: &quot;user@example.com&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTlogin" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTlogin"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTlogin"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTlogin" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTlogin">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTlogin" data-method="POST"
      data-path="login"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTlogin', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTlogin"
                    onclick="tryItOut('POSTlogin');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTlogin"
                    onclick="cancelTryOut('POSTlogin');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTlogin"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTlogin"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTlogin"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTlogin"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTlogin"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>The user's email. Example: <code>gbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTlogin"
               value="|]|{+-"
               data-component="body">
    <br>
<p>The user's password. Example: <code>|]|{+-</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTforgot-password">Reset password

Resets the user&#039;s password using the token.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTforgot-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/forgot-password" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"gbailey@example.net\",
    \"token\": \"architecto\",
    \"password\": \"|]|{+-\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/forgot-password"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "gbailey@example.net",
    "token": "architecto",
    "password": "|]|{+-"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTforgot-password">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Password reset successfully&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTforgot-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTforgot-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTforgot-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTforgot-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTforgot-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTforgot-password" data-method="POST"
      data-path="forgot-password"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTforgot-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTforgot-password"
                    onclick="tryItOut('POSTforgot-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTforgot-password"
                    onclick="cancelTryOut('POSTforgot-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTforgot-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>forgot-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTforgot-password"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTforgot-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTforgot-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTforgot-password"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>The user's email. Example: <code>gbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="token"                data-endpoint="POSTforgot-password"
               value="architecto"
               data-component="body">
    <br>
<p>The reset token. Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTforgot-password"
               value="|]|{+-"
               data-component="body">
    <br>
<p>The new password. Example: <code>|]|{+-</code></p>
        </div>
        </form>

                    <h2 id="authentication-GETreset-password--token-">Reset password

Resets the user&#039;s password using the token.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETreset-password--token-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/reset-password/architecto" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"token\": \"architecto\",
    \"email\": \"gbailey@example.net\",
    \"password\": \"|]|{+-\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/reset-password/architecto"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "token": "architecto",
    "email": "gbailey@example.net",
    "password": "|]|{+-"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETreset-password--token-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Password reset successfully&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETreset-password--token-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETreset-password--token-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETreset-password--token-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETreset-password--token-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETreset-password--token-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETreset-password--token-" data-method="GET"
      data-path="reset-password/{token}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETreset-password--token-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETreset-password--token-"
                    onclick="tryItOut('GETreset-password--token-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETreset-password--token-"
                    onclick="cancelTryOut('GETreset-password--token-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETreset-password--token-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>reset-password/{token}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETreset-password--token-"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETreset-password--token-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETreset-password--token-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="token"                data-endpoint="GETreset-password--token-"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="token"                data-endpoint="GETreset-password--token-"
               value="architecto"
               data-component="body">
    <br>
<p>The reset token. Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="GETreset-password--token-"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>The user's email. Example: <code>gbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="GETreset-password--token-"
               value="|]|{+-"
               data-component="body">
    <br>
<p>The new password. Example: <code>|]|{+-</code></p>
        </div>
        </form>

                    <h2 id="authentication-GETverify-email--id---hash-">Verify email

Marks the user&#039;s email as verified.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETverify-email--id---hash-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/verify-email/16/architecto" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/verify-email/16/architecto"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETverify-email--id---hash-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Email verified successfully&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETverify-email--id---hash-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETverify-email--id---hash-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETverify-email--id---hash-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETverify-email--id---hash-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETverify-email--id---hash-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETverify-email--id---hash-" data-method="GET"
      data-path="verify-email/{id}/{hash}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETverify-email--id---hash-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETverify-email--id---hash-"
                    onclick="tryItOut('GETverify-email--id---hash-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETverify-email--id---hash-"
                    onclick="cancelTryOut('GETverify-email--id---hash-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETverify-email--id---hash-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>verify-email/{id}/{hash}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETverify-email--id---hash-"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETverify-email--id---hash-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETverify-email--id---hash-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETverify-email--id---hash-"
               value="16"
               data-component="url">
    <br>
<p>User ID Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>hash</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="hash"                data-endpoint="GETverify-email--id---hash-"
               value="architecto"
               data-component="url">
    <br>
<p>Verification hash Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="authentication-POSTlogout">Logout a user

Logs out the authenticated user.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTlogout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/logout" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/logout"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTlogout">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Logged out successfully&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTlogout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTlogout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTlogout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTlogout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTlogout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTlogout" data-method="POST"
      data-path="logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTlogout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTlogout"
                    onclick="tryItOut('POSTlogout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTlogout"
                    onclick="cancelTryOut('POSTlogout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTlogout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTlogout"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTlogout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTlogout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="authentication-GETlogout">Logout a user

Logs out the authenticated user.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETlogout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/logout" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/logout"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETlogout">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Logged out successfully&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETlogout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETlogout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETlogout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETlogout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETlogout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETlogout" data-method="GET"
      data-path="logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETlogout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETlogout"
                    onclick="tryItOut('GETlogout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETlogout"
                    onclick="cancelTryOut('GETlogout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETlogout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETlogout"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETlogout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETlogout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-POSTapi-webhook-dojah">POST api/webhook/dojah</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-webhook-dojah">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/webhook/dojah" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/webhook/dojah"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-webhook-dojah">
</span>
<span id="execution-results-POSTapi-webhook-dojah" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-webhook-dojah"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-webhook-dojah"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-webhook-dojah" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-webhook-dojah">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-webhook-dojah" data-method="POST"
      data-path="api/webhook/dojah"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-webhook-dojah', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-webhook-dojah"
                    onclick="tryItOut('POSTapi-webhook-dojah');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-webhook-dojah"
                    onclick="cancelTryOut('POSTapi-webhook-dojah');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-webhook-dojah"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/webhook/dojah</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-webhook-dojah"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-webhook-dojah"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-webhook-dojah"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-kyc-webhook">POST api/kyc/webhook</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-kyc-webhook">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/kyc/webhook" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/kyc/webhook"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-kyc-webhook">
</span>
<span id="execution-results-POSTapi-kyc-webhook" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-kyc-webhook"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-kyc-webhook"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-kyc-webhook" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-kyc-webhook">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-kyc-webhook" data-method="POST"
      data-path="api/kyc/webhook"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-kyc-webhook', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-kyc-webhook"
                    onclick="tryItOut('POSTapi-kyc-webhook');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-kyc-webhook"
                    onclick="cancelTryOut('POSTapi-kyc-webhook');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-kyc-webhook"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/kyc/webhook</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-kyc-webhook"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-kyc-webhook"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-kyc-webhook"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-ping">GET api/ping</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-ping">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/ping" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/ping"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-ping">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;API is working 🚀&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-ping" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-ping"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-ping"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-ping" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-ping">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-ping" data-method="GET"
      data-path="api/ping"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-ping', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-ping"
                    onclick="tryItOut('GETapi-ping');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-ping"
                    onclick="cancelTryOut('GETapi-ping');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-ping"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/ping</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-ping"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-ping"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-ping"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-loan_payment_reminder">GET api/loan_payment_reminder</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-loan_payment_reminder">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/loan_payment_reminder" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/loan_payment_reminder"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-loan_payment_reminder">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;No pending repayments due soon.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-loan_payment_reminder" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-loan_payment_reminder"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-loan_payment_reminder"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-loan_payment_reminder" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-loan_payment_reminder">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-loan_payment_reminder" data-method="GET"
      data-path="api/loan_payment_reminder"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-loan_payment_reminder', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-loan_payment_reminder"
                    onclick="tryItOut('GETapi-loan_payment_reminder');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-loan_payment_reminder"
                    onclick="cancelTryOut('GETapi-loan_payment_reminder');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-loan_payment_reminder"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/loan_payment_reminder</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-loan_payment_reminder"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-loan_payment_reminder"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-loan_payment_reminder"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-auto-process-loans">GET api/auto-process-loans</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-auto-process-loans">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/auto-process-loans" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auto-process-loans"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-auto-process-loans">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Loan payments processed successfully.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-auto-process-loans" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-auto-process-loans"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auto-process-loans"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-auto-process-loans" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auto-process-loans">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-auto-process-loans" data-method="GET"
      data-path="api/auto-process-loans"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-auto-process-loans', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-auto-process-loans"
                    onclick="tryItOut('GETapi-auto-process-loans');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-auto-process-loans"
                    onclick="cancelTryOut('GETapi-auto-process-loans');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-auto-process-loans"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/auto-process-loans</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-auto-process-loans"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-auto-process-loans"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-auto-process-loans"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETregister">Display the registration view.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETregister">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/register" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/register"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETregister">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: text/html; charset=UTF-8
cache-control: no-cache, private
set-cookie: XSRF-TOKEN=eyJpdiI6InFTY2dIQ01Ubld0OTF5OEF5UFJiSXc9PSIsInZhbHVlIjoiZDd0ZlorTGk1cDluYnQ3Vm1mdGRMZnlsdFR3RCt0eitOcnVvK1R4T2ZaMkR5UXRySW5pcUIwWHFvUEtsUHFiakgyN1gvL0dyckExUDFUbEJyam9TSWoxbVk3QlJpdnk0Q0pHZzlnV1VTcGVFUktWM0RMRjRLQkxKSm5tUmp0NE4iLCJtYWMiOiJhYmQyMjQ3Njg2NmVkNWJhNTEwOWRlMmQwOWJjZDM4M2ExZDhmYWZlNWI1YjEwY2EwMTQzMjQ5NGI2MDQ0MWQ5IiwidGFnIjoiIn0%3D; expires=Wed, 31 Dec 2025 16:42:17 GMT; Max-Age=7200; path=/; samesite=lax; laravel_session=eyJpdiI6Ild5eS80MzlTb0s1WXNsTWMxb2V0M0E9PSIsInZhbHVlIjoieDFNaG5FNmNhMEw4ek1pWTVFeVJ6cEtyMExFNVhRelJVR1k3MXI5alpuZFhvZWxmcTN5M3YrRDJ5S1FLSjVKNzR2Zkwxdzl1S2FzSW9JL09YWlZ6cUdqcHF6SDNmV211LzU2VEhqYXdzM3FUd0owSTVJdUJnS3cxODJEOUVGRC8iLCJtYWMiOiIwYzYzYTQ4ZDlhZmFiNmY4OGJkMDZiNzcxYTk2YmYzNDg0ZWZjM2RkYjI2ZTNiZGM0M2JmODdiZDZlNGFhZDBlIiwidGFnIjoiIn0%3D; expires=Wed, 31 Dec 2025 16:42:17 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
  
&lt;!-- Mirrored from themes.pixelstrap.com/fuzzy/login.html by HTTrack Website Copier/3.x [XR&amp;CO&#039;2014], Tue, 02 Sep 2025 07:34:33 GMT --&gt;
&lt;head&gt;
    &lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=UTF-8&quot; /&gt;
    &lt;meta http-equiv=&quot;X-UA-Compatible&quot; content=&quot;IE=edge&quot; /&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1.0&quot; /&gt;
    &lt;meta name=&quot;description&quot; content=&quot;fuzzy&quot; /&gt;
    &lt;meta name=&quot;keywords&quot; content=&quot;fuzzy&quot; /&gt;
    &lt;meta name=&quot;author&quot; content=&quot;fuzzy&quot; /&gt;
    &lt;link rel=&quot;manifest&quot; href=&quot;manifest.json&quot; /&gt;
    &lt;title&gt;Aurelius&lt;/title&gt;
    &lt;meta name=&quot;theme-color&quot; content=&quot;#122636&quot; /&gt;
    &lt;meta name=&quot;apple-mobile-web-app-capable&quot; content=&quot;yes&quot; /&gt;
    &lt;meta name=&quot;apple-mobile-web-app-status-bar-style&quot; content=&quot;black&quot; /&gt;
    &lt;meta name=&quot;apple-mobile-web-app-title&quot; content=&quot;fuzzy&quot; /&gt;
    &lt;meta name=&quot;msapplication-TileImage&quot; content=&quot;assets/images/logo/favicon.png&quot; /&gt;
    &lt;meta name=&quot;msapplication-TileColor&quot; content=&quot;#FFFFFF&quot; /&gt;
    &lt;meta http-equiv=&quot;X-UA-Compatible&quot; content=&quot;IE=edge&quot; /&gt;

&lt;link rel=&quot;stylesheet&quot; href=&quot;https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css&quot; 
      crossorigin=&quot;anonymous&quot; referrerpolicy=&quot;no-referrer&quot; /&gt;
    &lt;!--Google font--&gt;
    
    &lt;!-- iconsax css --&gt;
    &lt;link rel=&quot;stylesheet&quot; type=&quot;text/css&quot; href=&quot;http://localhost/assets/css/vendors/iconsax.css&quot; /&gt;
    &lt;!-- bootstrap css --&gt;
    &lt;link rel=&quot;stylesheet&quot; id=&quot;rtl-link&quot; type=&quot;text/css&quot; href=&quot;http://localhost/assets/css/vendors/bootstrap.min.css&quot; /&gt;
    &lt;!-- Theme css --&gt;
    &lt;link rel=&quot;stylesheet&quot; id=&quot;change-link&quot; type=&quot;text/css&quot; href=&quot;http://localhost/assets/css/style.css&quot; /&gt;
  &lt;/head&gt;

  &lt;body class=&quot;auth-body&quot;&gt;
  &lt;style&gt;
  .auth-form .form-control {
  color: rgb(0, 0, 0) !important;          /* Black text inside input */
  background-color: rgb(255, 255, 255) !important; /* White background */
  border: 1px solid rgba(0, 0, 0, 0.2) !important; /* Light border */
}

.auth-form .form-control::placeholder {
  color: rgba(0, 0, 0, 0.5) !important; /* Slightly faded placeholder */
}



    .action_modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .action_modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .action_modal {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 32px;
        max-width: 400px;
        width: 90%;
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.3);
        transform: scale(0.9) translateY(20px);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        text-align: center;
        position: relative;
    }

    .action_modal-overlay.active .action_modal {
        transform: scale(1) translateY(0);
    }

    .action_modal-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .action_modal-icon.success {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .action_modal-icon.error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .action_modal-icon.info {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .action_modal-icon.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .action_modal-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1f2937;
    }

    .action_modal-message {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .action_modal-btn {
        padding: 12px 28px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
    }

    .action_modal-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }
&lt;/style&gt;

&lt;!-- Modal HTML --&gt;
&lt;div class=&quot;action_modal-overlay&quot; id=&quot;clipboardModal&quot; onclick=&quot;closeClipboardModal(event)&quot;&gt;
    &lt;div class=&quot;action_modal&quot; onclick=&quot;event.stopPropagation()&quot;&gt;
        &lt;div class=&quot;action_modal-icon&quot; id=&quot;modalIcon&quot;&gt;
            &lt;span id=&quot;modalIconText&quot;&gt;&lt;i class=&quot;fa fa-info-circle text-white&quot;&gt;&lt;/i&gt;&lt;/span&gt;
        &lt;/div&gt;
        &lt;h3 class=&quot;action_modal-title&quot; id=&quot;modalTitle&quot;&gt;Notice&lt;/h3&gt;
        &lt;p class=&quot;action_modal-message&quot; id=&quot;modalMessage&quot;&gt;This is a message.&lt;/p&gt;
        &lt;button class=&quot;action_modal-btn&quot; onclick=&quot;closeClipboardModal()&quot;&gt;Ok&lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Modal JS --&gt;
&lt;script&gt;
    function showSessionModal(type, message) {
        const overlay = document.getElementById(&#039;clipboardModal&#039;);
        const icon = document.getElementById(&#039;modalIcon&#039;);
        const iconText = document.getElementById(&#039;modalIconText&#039;);
        const title = document.getElementById(&#039;modalTitle&#039;);
        const msg = document.getElementById(&#039;modalMessage&#039;);

        // Reset classes to allow proper icon color
        icon.className = &#039;action_modal-icon&#039;;

        if (type === &#039;success&#039;) {
            icon.classList.add(&#039;success&#039;);
            iconText.innerHTML = &#039;&lt;i class=&quot;fa fa-check-circle text-white&quot;&gt;&lt;/i&gt;&#039;;
            title.textContent = &#039;Success!&#039;;
        } else if (type === &#039;info&#039;) {
            icon.classList.add(&#039;info&#039;);
            iconText.innerHTML = &#039;&lt;i class=&quot;fa fa-info-circle text-white&quot;&gt;&lt;/i&gt;&#039;;
            title.textContent = &#039;Info&#039;;
        } else if (type === &#039;warning&#039;) {
            icon.classList.add(&#039;warning&#039;);
            iconText.innerHTML = &#039;&lt;i class=&quot;fa fa-exclamation-triangle text-white&quot;&gt;&lt;/i&gt;&#039;;
            title.textContent = &#039;Warning&#039;;
        } else if (type === &#039;error&#039;) {
            icon.classList.add(&#039;error&#039;);
            iconText.innerHTML = &#039;&lt;i class=&quot;fa fa-times-circle text-white&quot;&gt;&lt;/i&gt;&#039;;
            title.textContent = &#039;Error&#039;;
        } else {
            icon.classList.add(&#039;info&#039;);
            iconText.innerHTML = &#039;&lt;i class=&quot;fa fa-info-circle text-white&quot;&gt;&lt;/i&gt;&#039;;
            title.textContent = &#039;Notice&#039;;
        }

        msg.textContent = message;
        overlay.classList.add(&#039;active&#039;);
        document.body.style.overflow = &#039;hidden&#039;;
    }

    function closeClipboardModal(event) {
        if (event &amp;&amp; event.target !== event.currentTarget) return;

        const overlay = document.getElementById(&#039;clipboardModal&#039;);
        overlay.classList.remove(&#039;active&#039;);
        document.body.style.overflow = &#039;&#039;;
    }

    // Close modal on Escape key press
    document.addEventListener(&#039;keydown&#039;, function(event) {
        if (event.key === &#039;Escape&#039;) {
            closeClipboardModal();
        }
    });

    &lt;/script&gt;

&lt;/style&gt;
    &lt;!-- login section start --&gt;
    



&lt;div class=&quot;auth-img&quot;&gt;
    &lt;img class=&quot;img-fluid auth-bg&quot;
        src=&quot;https://www.agrohandlers.com/uploaded_files/blog-pix/202309180828_ORGANIC-FOOD-STORE-BUSINESS-PLAN-IN-NIGERIA.jpg&quot;
        alt=&quot;auth_bg&quot; /&gt;
    &lt;div class=&quot;auth-content&quot;&gt;
        &lt;div&gt;
            &lt;h2&gt;Create Account&lt;/h2&gt;
            &lt;h4 class=&quot;p-0&quot;&gt;Join us today, it only takes a minute!&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;form class=&quot;auth-form&quot; method=&quot;POST&quot; action=&quot;http://localhost/register&quot; enctype=&quot;multipart/form-data&quot;&gt;
    &lt;input type=&quot;hidden&quot; name=&quot;_token&quot; value=&quot;nPYnI3nDk0aAjpAMJRQuowuCOoT9vTnZxLr94hE4&quot; autocomplete=&quot;off&quot;&gt;    &lt;div class=&quot;custom-container&quot;&gt;

        
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;first_name&quot; class=&quot;form-label&quot;&gt;First Name&lt;/label&gt;
            &lt;input type=&quot;text&quot; id=&quot;first_name&quot; name=&quot;first_name&quot;
                class=&quot;form-control &quot;
                placeholder=&quot;Enter First Name&quot; value=&quot;&quot; required&gt;
                    &lt;/div&gt;

        
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;last_name&quot; class=&quot;form-label&quot;&gt;Last Name&lt;/label&gt;
            &lt;input type=&quot;text&quot; id=&quot;last_name&quot; name=&quot;last_name&quot;
                class=&quot;form-control &quot;
                placeholder=&quot;Enter Last Name&quot; value=&quot;&quot; required&gt;
                    &lt;/div&gt;

        
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;email&quot; class=&quot;form-label&quot;&gt;Email Address&lt;/label&gt;
            &lt;input type=&quot;email&quot; id=&quot;email&quot; name=&quot;email&quot;
                class=&quot;form-control &quot;
                placeholder=&quot;Enter Email&quot; value=&quot;&quot; required&gt;
                    &lt;/div&gt;

        
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;phone&quot; class=&quot;form-label&quot;&gt;Phone Number&lt;/label&gt;
            &lt;input type=&quot;text&quot; id=&quot;phone&quot; name=&quot;phone&quot;
                class=&quot;form-control &quot;
                placeholder=&quot;Enter Phone Number&quot; value=&quot;&quot; required&gt;
                    &lt;/div&gt;

        
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;state&quot; class=&quot;form-label&quot;&gt;State&lt;/label&gt;
            &lt;select name=&quot;state&quot; id=&quot;state&quot; class=&quot;form-control &quot; required&gt;
                &lt;option value=&quot;&quot;&gt;Loading States...&lt;/option&gt;
            &lt;/select&gt;
                    &lt;/div&gt;

        
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;lga&quot; class=&quot;form-label&quot;&gt;Local Government Area (LGA)&lt;/label&gt;
            &lt;select name=&quot;lga&quot; id=&quot;lga&quot; class=&quot;form-control &quot; required&gt;
                &lt;option value=&quot;&quot;&gt;Select State First&lt;/option&gt;
            &lt;/select&gt;
                    &lt;/div&gt;

        &lt;input type=&quot;hidden&quot; name=&quot;country&quot; value=&quot;Nigeria&quot;&gt;

        
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;employee_status&quot; class=&quot;form-label&quot;&gt;Employee Status&lt;/label&gt;
            &lt;select id=&quot;employee_status&quot; name=&quot;employee_status&quot;
                class=&quot;form-control &quot; required&gt;
                &lt;option value=&quot;&quot;&gt;Select Status&lt;/option&gt;
                &lt;option value=&quot;Employed&quot;&gt;Employed&lt;/option&gt;
                &lt;option value=&quot;Non Student/Non Employed&quot;&gt;Non Student / Non Employed&lt;/option&gt;
                &lt;option value=&quot;Trader&quot;&gt;Trader&lt;/option&gt;
                &lt;option value=&quot;Student&quot;&gt;Student&lt;/option&gt;
            &lt;/select&gt;
                    &lt;/div&gt;

        
        &lt;div id=&quot;student_fields&quot; style=&quot;display:none;&quot;&gt;
            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label for=&quot;student_id&quot; class=&quot;form-label&quot;&gt;Student ID Card&lt;/label&gt;
                &lt;input type=&quot;file&quot; id=&quot;student_id&quot; name=&quot;student_id&quot;
                    class=&quot;form-control &quot;&gt;
                            &lt;/div&gt;

            &lt;div class=&quot;form-group&quot;&gt;
                &lt;label for=&quot;school_name&quot; class=&quot;form-label&quot;&gt;School Name&lt;/label&gt;
                &lt;input type=&quot;text&quot; id=&quot;school_name&quot; name=&quot;school_name&quot;
                    class=&quot;form-control &quot;
                    placeholder=&quot;Enter School Name&quot;&gt;
                            &lt;/div&gt;
        &lt;/div&gt;

&lt;div class=&quot;form-group&quot;&gt;
    &lt;label for=&quot;referral_code&quot; class=&quot;form-label&quot;&gt;Referral Code (optional)&lt;/label&gt;
    &lt;input type=&quot;text&quot; id=&quot;referral_code&quot; name=&quot;referral_code&quot;
        class=&quot;form-control &quot;
        placeholder=&quot;Enter referral code if any&quot; value=&quot;&quot;&gt;
    &lt;/div&gt;

        
        &lt;div class=&quot;form-group position-relative&quot;&gt;
            &lt;label for=&quot;password&quot; class=&quot;form-label&quot;&gt;Password&lt;/label&gt;
            &lt;input type=&quot;password&quot; id=&quot;password&quot; name=&quot;password&quot;
                class=&quot;form-control &quot;
                placeholder=&quot;Enter Password&quot; required&gt;
            &lt;button type=&quot;button&quot; class=&quot;toggle-password&quot; onclick=&quot;togglePassword(&#039;password&#039;)&quot;
                style=&quot;position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border:none; background:transparent; cursor:pointer;&quot;&gt;
                👁
            &lt;/button&gt;
                    &lt;/div&gt;

        
        &lt;div class=&quot;form-group position-relative&quot;&gt;
            &lt;label for=&quot;password_confirmation&quot; class=&quot;form-label&quot;&gt;Confirm Password&lt;/label&gt;
            &lt;input type=&quot;password&quot; id=&quot;password_confirmation&quot; name=&quot;password_confirmation&quot;
                class=&quot;form-control&quot; placeholder=&quot;Re-enter Password&quot; required&gt;
            &lt;button type=&quot;button&quot; class=&quot;toggle-password&quot; onclick=&quot;togglePassword(&#039;password_confirmation&#039;)&quot;
                style=&quot;position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border:none; background:transparent; cursor:pointer;&quot;&gt;
                👁
            &lt;/button&gt;
        &lt;/div&gt;

        
        &lt;div class=&quot;submit-btn mt-3&quot;&gt;
            &lt;button type=&quot;button&quot; class=&quot;btn auth-btn w-100&quot; id=&quot;proceedBtn&quot;&gt;
                &lt;i class=&quot;fa fa-arrow-right&quot;&gt;&lt;/i&gt; Proceed
            &lt;/button&gt;
        &lt;/div&gt;

        &lt;h4 class=&quot;signup mt-3&quot;&gt;
            Already have an account?
            &lt;a style=&quot;color:black; font-weight:bold;&quot; href=&quot;http://localhost/login&quot;&gt;Sign In&lt;/a&gt;
        &lt;/h4&gt;
    &lt;/div&gt;
&lt;/form&gt;

&lt;!-- Terms Modal --&gt;
&lt;div class=&quot;modal fade&quot; id=&quot;termsModal&quot; tabindex=&quot;-1&quot; aria-labelledby=&quot;termsModalLabel&quot; aria-hidden=&quot;true&quot;
     data-bs-backdrop=&quot;static&quot; data-bs-keyboard=&quot;false&quot;&gt;
  &lt;div class=&quot;modal-dialog modal-lg&quot;&gt;
    &lt;div class=&quot;modal-content&quot;&gt;
      &lt;div class=&quot;modal-header&quot;&gt;
        &lt;h5 class=&quot;modal-title&quot; id=&quot;termsModalLabel&quot;&gt;Terms of Use&lt;/h5&gt;
      &lt;/div&gt;

      &lt;div class=&quot;modal-body terms-content&quot; style=&quot;max-height: 400px; overflow-y: auto; line-height: 1.6;&quot;&gt;
        Not Set
      &lt;/div&gt;

      &lt;div class=&quot;modal-footer d-flex justify-content-between terms-footer&quot; style=&quot;display: none; opacity: 0; transition: opacity 0.3s ease;&quot;&gt;
        &lt;button  type=&quot;button&quot; class=&quot;btn btn-dark&quot; data-bs-dismiss=&quot;modal&quot;&gt;Decline&lt;/button&gt;
        &lt;button style=&quot;background:darkorange; color:white;&quot; type=&quot;button&quot; class=&quot;btn btn-warning&quot; id=&quot;acceptTermsBtn&quot;&gt;Accept&lt;/button&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;

&lt;script&gt;
document.addEventListener(&#039;DOMContentLoaded&#039;, function() {
    const modal = document.getElementById(&#039;termsModal&#039;);

    modal.addEventListener(&#039;shown.bs.modal&#039;, function() {
        const termsBody = modal.querySelector(&#039;.terms-content&#039;);
        const footer = modal.querySelector(&#039;.terms-footer&#039;);

        // Always hide the buttons first when modal opens
        footer.style.display = &#039;none&#039;;
        footer.style.opacity = &#039;0&#039;;

        if (termsBody &amp;&amp; footer) {
            // When user scrolls
            termsBody.addEventListener(&#039;scroll&#039;, function onScroll() {
                const scrollPosition = termsBody.scrollTop + termsBody.clientHeight;
                const scrollHeight = termsBody.scrollHeight;

                // If user reaches bottom of scrollable area
                if (scrollPosition &gt;= scrollHeight - 5) {
                    footer.style.display = &#039;flex&#039;;
                    setTimeout(() =&gt; footer.style.opacity = &#039;1&#039;, 50);
                } else {
                    // Hide again if user scrolls back up
                    footer.style.opacity = &#039;0&#039;;
                    setTimeout(() =&gt; footer.style.display = &#039;none&#039;, 300);
                }
            });
        }
    });
});
&lt;/script&gt;


&lt;script&gt;
function togglePassword(fieldId) {
    let field = document.getElementById(fieldId);
    field.type = field.type === &quot;password&quot; ? &quot;text&quot; : &quot;password&quot;;
}

document.addEventListener(&quot;DOMContentLoaded&quot;, function () {
    const employeeStatus = document.getElementById(&quot;employee_status&quot;);
    const studentFields = document.getElementById(&quot;student_fields&quot;);
    const studentIdInput = document.getElementById(&quot;student_id&quot;);
    const schoolNameInput = document.getElementById(&quot;school_name&quot;);

    function toggleStudentFields() {
        if (employeeStatus.value === &quot;Student&quot;) {
            studentFields.style.display = &quot;block&quot;;
            studentIdInput.required = true;
            schoolNameInput.required = true;
        } else {
            studentFields.style.display = &quot;none&quot;;
            studentIdInput.required = false;
            schoolNameInput.required = false;
            studentIdInput.value = &quot;&quot;;
            schoolNameInput.value = &quot;&quot;;
        }
    }

    employeeStatus.addEventListener(&quot;change&quot;, toggleStudentFields);
    toggleStudentFields();

    // Load states
    fetch(&quot;http://localhost/locations/states&quot;)
        .then(res =&gt; res.json())
        .then(states =&gt; {
            let stateDropdown = document.getElementById(&quot;state&quot;);
            stateDropdown.innerHTML = &#039;&lt;option value=&quot;&quot;&gt;Select State&lt;/option&gt;&#039;;
            states.forEach(state =&gt; {
                stateDropdown.innerHTML += `&lt;option value=&quot;${state.id}&quot;&gt;${state.name}&lt;/option&gt;`;
            });
        });

    // Load LGAs
    document.getElementById(&quot;state&quot;).addEventListener(&quot;change&quot;, function() {
        let selectedState = this.value;
        let lgaDropdown = document.getElementById(&quot;lga&quot;);
        if (selectedState) {
            lgaDropdown.innerHTML = &#039;&lt;option&gt;Loading LGAs...&lt;/option&gt;&#039;;
            fetch(&quot;http://localhost/locations/lgas/&quot; + encodeURIComponent(selectedState))
                .then(res =&gt; res.json())
                .then(data =&gt; {
                    lgaDropdown.innerHTML = &#039;&lt;option value=&quot;&quot;&gt;Select LGA&lt;/option&gt;&#039;;
                    if (data.lgas) {
                        data.lgas.forEach(lga =&gt; {
                            lgaDropdown.innerHTML += `&lt;option value=&quot;${lga}&quot;&gt;${lga}&lt;/option&gt;`;
                        });
                    }
                });
        } else {
            lgaDropdown.innerHTML = &#039;&lt;option value=&quot;&quot;&gt;Select State First&lt;/option&gt;&#039;;
        }
    });

    // Proceed Button &rarr; Open Terms Modal
    document.getElementById(&quot;proceedBtn&quot;).addEventListener(&quot;click&quot;, function() {
        let termsModal = new bootstrap.Modal(document.getElementById(&quot;termsModal&quot;));
        termsModal.show();
    });

    
});


&lt;/script&gt;

&lt;script&gt;
document.addEventListener(&quot;DOMContentLoaded&quot;, function () {
    const form = document.querySelector(&quot;.auth-form&quot;);
    const proceedBtn = document.getElementById(&quot;proceedBtn&quot;);
    const acceptBtn = document.getElementById(&quot;acceptTermsBtn&quot;);

    acceptBtn.addEventListener(&quot;click&quot;, async function () {
        const modalEl = document.getElementById(&quot;termsModal&quot;);
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        modalInstance.hide();

        // Clear previous validation messages
        document.querySelectorAll(&quot;.text-danger&quot;).forEach(el =&gt; el.innerHTML = &quot;&quot;);

        // Disable the Proceed button and show spinner
        proceedBtn.disabled = true;
        proceedBtn.innerHTML = &#039;&lt;i class=&quot;fa fa-spinner fa-spin&quot;&gt;&lt;/i&gt; Processing...&#039;;

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: &quot;POST&quot;,
                headers: {
                    &quot;X-Requested-With&quot;: &quot;XMLHttpRequest&quot;,
                    &quot;X-CSRF-TOKEN&quot;: document.querySelector(&quot;input[name=&#039;_token&#039;]&quot;).value,
                },
                body: formData
            });

            const data = await response.json();

            // Re-enable the Proceed button
            proceedBtn.disabled = false;
            proceedBtn.innerHTML = &#039;&lt;i class=&quot;fa fa-arrow-right&quot;&gt;&lt;/i&gt; Proceed&#039;;

            if (response.status === 422) {
                // Validation errors
                Object.keys(data.errors).forEach(field =&gt; {
                    let input = document.querySelector(`[name=&quot;${field}&quot;]`);
                    if (input) {
                        let errorTag = input.parentElement.querySelector(&quot;.text-danger&quot;);
                        if (!errorTag) {
                            errorTag = document.createElement(&quot;small&quot;);
                            errorTag.classList.add(&quot;text-danger&quot;);
                            input.parentElement.appendChild(errorTag);
                        }
                        errorTag.innerHTML = data.errors[field][0];
                    }
                });
            } else if (data.status === &quot;success&quot;) {
                showSessionModal(&#039;success&#039;, data.message + &#039; Redirecting in 5sec&#039;)
setTimeout(() =&gt; {
        window.location.href = data.redirect;
    }, 5000);            } else {
            showSessionModal(&#039;error&#039;, data.message || &quot;An unexpected error occurred.&quot;);

            }

        } catch (error) {
            console.error(error);
                        showSessionModal(&#039;error&#039;, error.message || &quot;Network error, please try again.&quot;);


            // Restore button if network fails
            proceedBtn.disabled = false;
            proceedBtn.innerHTML = &#039;&lt;i class=&quot;fa fa-arrow-right&quot;&gt;&lt;/i&gt; Proceed&#039;;
        }
    });
});
&lt;/script&gt;



    &lt;!-- login section end--&gt;

    &lt;!-- iconsax js --&gt;
    &lt;script src=&quot;http://localhost/assets/js/iconsax.js&quot;&gt;&lt;/script&gt;

    &lt;!-- bootstrap js --&gt;
    &lt;script src=&quot;http://localhost/assets/js/bootstrap.bundle.min.js&quot;&gt;&lt;/script&gt;

    &lt;!-- script js --&gt;
    &lt;script src=&quot;http://localhost/assets/js/script.js&quot;&gt;&lt;/script&gt;
  &lt;/body&gt;

&lt;/html&gt;
</code>
 </pre>
    </span>
<span id="execution-results-GETregister" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETregister"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETregister"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETregister" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETregister">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETregister" data-method="GET"
      data-path="register"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETregister', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETregister"
                    onclick="tryItOut('GETregister');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETregister"
                    onclick="cancelTryOut('GETregister');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETregister"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETregister"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETregister"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETregister"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETforgot-password">Display the password reset link request view.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETforgot-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/forgot-password" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/forgot-password"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETforgot-password">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: text/html; charset=UTF-8
cache-control: no-cache, private
set-cookie: XSRF-TOKEN=eyJpdiI6InZ4Y2FXYXc3bC9jWktDeGp1cm15Q3c9PSIsInZhbHVlIjoiZWcxSCtrNUVDY1NvRXR3OFRyeUllMEl5WGJaQXIzeGZkM0FsRWFNNW91bHVLdzdJalZXemVmd055ZnowRldzY092Q2JuR1NQMUZiRmRHWmpoemM4a2tLcG91QmtoNWVScFZ5L2F1bGovekVDR1dXRW96RHRxdlJvKzBTUW5ERUEiLCJtYWMiOiIzNDMzYzg5YTIzNjdmN2E5MDIyM2Q3Zjk2MGZkOGJiMGQ4NDRiOTA5NDc4NzkyMmQ5MjY3Zjc0MmMxNDY3ZDQ5IiwidGFnIjoiIn0%3D; expires=Wed, 31 Dec 2025 16:42:17 GMT; Max-Age=7200; path=/; samesite=lax; laravel_session=eyJpdiI6Ijhidi9lOTFhQjBleWhrUFFHdlBiSXc9PSIsInZhbHVlIjoiWmhzQytsRmt3WUQ4Rzgyc1ZuSFlsSHJCMitISXRqT0YxZ3BnenZMS0JQWjUrTDQ4c2dTTkd0RUIydFI5SUIzMUYxV3c0MVl6N08vVFcvUWd6TUl6bWQ4ZlhGNCs1THJOb04xckthSFBLOEZpUzIwM1hLWmp0eU93NzBHbFJuU0MiLCJtYWMiOiIyOWQ1Y2I0NmMzMmRlNDNkYmYwMmQyZWQ5MjZmYzExOWYxMmFhMDc2MWE5NGI4ZWIxYzU1ZDA2MGUxZmRmMGFlIiwidGFnIjoiIn0%3D; expires=Wed, 31 Dec 2025 16:42:17 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1.0&quot;&gt;
    &lt;title&gt;Forgot Password&lt;/title&gt;
    &lt;style&gt;
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .text-muted {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            color: #444;
        }

        input[type=&quot;email&quot;] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type=&quot;email&quot;]:focus {
            border-color: #007bff;
        }

        .error {
            color: #e3342f;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #1e40af;
        }

        .status-message {
            background: #d1fae5;
            color: #065f46;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }
    &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;

&lt;div class=&quot;container&quot;&gt;
&lt;div style=&quot;text-align:center;&quot; class=&quot;brand-logo&quot;&gt;
                &lt;a href=&quot;#&quot;&gt;
                    &lt;img style=&quot;width:120px; text-align:center;&quot; src=&quot;http://localhost/logo.png&quot; alt=&quot;Logo&quot;&gt;
                &lt;/a&gt;
            &lt;/div&gt;

    &lt;h2&gt;Forgot Password&lt;/h2&gt;

    &lt;p class=&quot;text-muted&quot;&gt;
        Forgot your password? No problem. Just let us know your email address and we&rsquo;ll email you a password reset link that will allow you to choose a new one.
    &lt;/p&gt;

    &lt;!-- Session Status --&gt;
    
    &lt;!-- Forgot Password Form --&gt;
    &lt;form method=&quot;POST&quot; action=&quot;http://localhost/forgot-password&quot;&gt;
        &lt;input type=&quot;hidden&quot; name=&quot;_token&quot; value=&quot;nPYnI3nDk0aAjpAMJRQuowuCOoT9vTnZxLr94hE4&quot; autocomplete=&quot;off&quot;&gt;
        &lt;div&gt;
            &lt;label for=&quot;email&quot;&gt;Email&lt;/label&gt;
            &lt;input id=&quot;email&quot; type=&quot;email&quot; name=&quot;email&quot; value=&quot;&quot; required autofocus&gt;
                    &lt;/div&gt;

        &lt;div style=&quot;margin-top: 20px;&quot;&gt;
            &lt;button style=&quot;background:darkorange;&quot; type=&quot;submit&quot; class=&quot;btn&quot;&gt;Email Password Reset Link&lt;/button&gt;
        &lt;/div&gt;
    &lt;/form&gt;
&lt;/div&gt;

&lt;/body&gt;
&lt;/html&gt;
</code>
 </pre>
    </span>
<span id="execution-results-GETforgot-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETforgot-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETforgot-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETforgot-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETforgot-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETforgot-password" data-method="GET"
      data-path="forgot-password"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETforgot-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETforgot-password"
                    onclick="tryItOut('GETforgot-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETforgot-password"
                    onclick="cancelTryOut('GETforgot-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETforgot-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>forgot-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETforgot-password"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETforgot-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETforgot-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETget-lgas--state-">GET get-lgas/{state}</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETget-lgas--state-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/get-lgas/architecto" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/get-lgas/architecto"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETget-lgas--state-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
set-cookie: XSRF-TOKEN=eyJpdiI6Ik5hajgxK2xXeExxUWdxWWQ5NFpLaHc9PSIsInZhbHVlIjoiKzdUR0x3bFVWM21DN3A0MDduRmUwWUpEby9IN3VCMlBGZmtPMFZ1VHFXRGVvOU5xcCsweTBMeGR5R2RlcmxzdUxHVGNNZkxMak9ZTmZYU0M2Z0YzR3hUVVpaWm5semxtYUgyTnJRUVlpTlBlYVo5UG1JTzdHVGxFcTNyMllYYjEiLCJtYWMiOiJlOGFhMGJlYmNiODU4ZjU5OTRjMWNkNzI5MTI4OTM4NmQ4ZWFkZDhkMjIzMzM4NDY5NDZkZjkwODFhYjJhMmQ4IiwidGFnIjoiIn0%3D; expires=Wed, 31 Dec 2025 16:42:18 GMT; Max-Age=7200; path=/; samesite=lax; laravel_session=eyJpdiI6IjRxdzRlQUVsaHF6ZlFLazlIQzBteWc9PSIsInZhbHVlIjoieW0xejNpVHphbTJqQjh5c0h5T21pV09uVFR4RmswRHRxakRRVk5BSG5Da25EbnNGWnJRRFZJbXNFS0k1SlNRYWxuOXhWK3BLM08raVh1eWRWK1pBTGJDcy9JRUh3SVJnRTdNaVNzbkxUeW1wVTlCUWF6Wk9XekNEUklyQnY3OWciLCJtYWMiOiJlZTEyN2UxZGMxNjhjOWU0MDUzODViMDJkNDkzMDM3NGU1NWE2Y2Y4NjI4NTgxZmJkZjdjODEwNmYzODliYzkxIiwidGFnIjoiIn0%3D; expires=Wed, 31 Dec 2025 16:42:18 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: 400,
    &quot;message&quot;: &quot;State with the requested ID does not exist&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETget-lgas--state-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETget-lgas--state-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETget-lgas--state-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETget-lgas--state-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETget-lgas--state-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETget-lgas--state-" data-method="GET"
      data-path="get-lgas/{state}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETget-lgas--state-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETget-lgas--state-"
                    onclick="tryItOut('GETget-lgas--state-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETget-lgas--state-"
                    onclick="cancelTryOut('GETget-lgas--state-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETget-lgas--state-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>get-lgas/{state}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETget-lgas--state-"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETget-lgas--state-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETget-lgas--state-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>state</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="state"                data-endpoint="GETget-lgas--state-"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETverify-email">Display the email verification prompt.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETverify-email">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/verify-email" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/verify-email"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETverify-email">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
set-cookie: XSRF-TOKEN=eyJpdiI6InVoS3FlRVQ5eDgyeSs0eUJ2VEFqTGc9PSIsInZhbHVlIjoiQmgrYkQrY3UwcUEyRisyVTFtSFpCdnU0dVRtaHJKU2Z2S2pISVluMHc2LzRQT1BZU29ESUJYY0dWdzVINEpIOWl2empWWmZuRHAzNlcwV1ZIVU5FT2xjYXVNdVpSQmd0SFdQK0IyNDIyWnI5c0dmcGR6cG4xODJUSTg0UDlUcWciLCJtYWMiOiIzNjI3NzI0YmEwZWVkZDM2OTI2ZmFlNzFmZDYxYzUyZWU2ZmU5OTdkYWZhMTBkOTMyNjZhM2I2YjNlMzhhZjk5IiwidGFnIjoiIn0%3D; expires=Wed, 31 Dec 2025 16:42:18 GMT; Max-Age=7200; path=/; samesite=lax; laravel_session=eyJpdiI6InlLNHRhNExiUEJGQVErcXFOa2RQakE9PSIsInZhbHVlIjoiM0w3YmxaTEtEWTZGYW5HaUJLQzNaVnlkOFEyZWZXd2Z0eHl2Qlh0dEduQ0VBSTltRGppUWdkN1grR0J4V1dYdE9wMUtwRkRqNnBVdnpxQ21CQitCZlVGWHFQQVowdjUzY3RIYlM4NDFUUDNWdE8zTDNpK2dxU01GaVVtNWJXZkQiLCJtYWMiOiJkMWVhZDZhNjE5ZGQyMGM5ZTEwZDYyOWY4N2YwYzA5ZDkzMWJhNWM2ZWU4NjAyZmM1M2E3YWI5OGM4NmVmNmI3IiwidGFnIjoiIn0%3D; expires=Wed, 31 Dec 2025 16:42:18 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETverify-email" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETverify-email"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETverify-email"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETverify-email" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETverify-email">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETverify-email" data-method="GET"
      data-path="verify-email"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETverify-email', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETverify-email"
                    onclick="tryItOut('GETverify-email');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETverify-email"
                    onclick="cancelTryOut('GETverify-email');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETverify-email"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>verify-email</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETverify-email"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETverify-email"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETverify-email"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTemail-verification-notification">Send a new email verification notification.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTemail-verification-notification">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/email/verification-notification" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/email/verification-notification"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTemail-verification-notification">
</span>
<span id="execution-results-POSTemail-verification-notification" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTemail-verification-notification"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTemail-verification-notification"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTemail-verification-notification" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTemail-verification-notification">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTemail-verification-notification" data-method="POST"
      data-path="email/verification-notification"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTemail-verification-notification', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTemail-verification-notification"
                    onclick="tryItOut('POSTemail-verification-notification');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTemail-verification-notification"
                    onclick="cancelTryOut('POSTemail-verification-notification');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTemail-verification-notification"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>email/verification-notification</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTemail-verification-notification"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTemail-verification-notification"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTemail-verification-notification"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETconfirm-password">Show the confirm password view.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETconfirm-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/confirm-password" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/confirm-password"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETconfirm-password">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
set-cookie: XSRF-TOKEN=eyJpdiI6IjRObkx6S2pHTktiWXZCU2ZBc1I3Z0E9PSIsInZhbHVlIjoiYVFuM1FRZzRkeWtoYUdMNlJYVngvL2tKblJLVDBRM2IyMnNvdXV2MTRRVDhoSVMxVWtMRzEzKzBteFAxNVlSeFNRSDdUa0twSlFUenpwMzY5cDhVY055U1ZSeXUyMU16MWF3YjdKNWU5b0xiWi80anQ5YWtiZ2ZTVnJnQ1MzQ24iLCJtYWMiOiI4NzAyMGNhN2JhZjk2NzU4ODhhZWY5NzFmOTg2YmUxNTY1ODA4MzMxODI0NmM1MTgwYmEyZTk0ZjYxNWZiOWY1IiwidGFnIjoiIn0%3D; expires=Wed, 31 Dec 2025 16:42:18 GMT; Max-Age=7200; path=/; samesite=lax; laravel_session=eyJpdiI6IkJSZjlXVTFrNlBtTmVOUlVOYnI0N1E9PSIsInZhbHVlIjoiOU82QzhlbVRyU3dTa3dOSHB5MUFEMTRIT1BnUnhqbWxxcTAvUDMrMzVoQlcrQk1HS1BHM0NTTnFwUnorcmcxYW9melZUVzIreGw3VzJUaCtvRklkdytTb3lzQ0E1dVc2YzE3WEdNNFV2clM1SXBnVTlGS1I5Nm9TVjhsTXdWdTMiLCJtYWMiOiJiMjg4ZWY0Mjg1ZGE4N2ZkYWE1Nzk4MzQyMTI5M2VlMDliZWI5OTQyN2YxYzFkYzliZDg3YWY5MWE5ZjM3MzJiIiwidGFnIjoiIn0%3D; expires=Wed, 31 Dec 2025 16:42:18 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETconfirm-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETconfirm-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETconfirm-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETconfirm-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETconfirm-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETconfirm-password" data-method="GET"
      data-path="confirm-password"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETconfirm-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETconfirm-password"
                    onclick="tryItOut('GETconfirm-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETconfirm-password"
                    onclick="cancelTryOut('GETconfirm-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETconfirm-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>confirm-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETconfirm-password"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETconfirm-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETconfirm-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTconfirm-password">Confirm the user&#039;s password.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTconfirm-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/confirm-password" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/confirm-password"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTconfirm-password">
</span>
<span id="execution-results-POSTconfirm-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTconfirm-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTconfirm-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTconfirm-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTconfirm-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTconfirm-password" data-method="POST"
      data-path="confirm-password"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTconfirm-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTconfirm-password"
                    onclick="tryItOut('POSTconfirm-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTconfirm-password"
                    onclick="cancelTryOut('POSTconfirm-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTconfirm-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>confirm-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTconfirm-password"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTconfirm-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTconfirm-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-PUTpassword">Update the user&#039;s password.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PUTpassword">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/password" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"current_password\": \"architecto\",
    \"password\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/password"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "current_password": "architecto",
    "password": "architecto"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTpassword">
</span>
<span id="execution-results-PUTpassword" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTpassword"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTpassword"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTpassword" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTpassword">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTpassword" data-method="PUT"
      data-path="password"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTpassword', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTpassword"
                    onclick="tryItOut('PUTpassword');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTpassword"
                    onclick="cancelTryOut('PUTpassword');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTpassword"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTpassword"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTpassword"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTpassword"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>current_password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="current_password"                data-endpoint="PUTpassword"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="PUTpassword"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
