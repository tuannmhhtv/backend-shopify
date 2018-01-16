
<!doctype html>
<html class="no-js" lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Instagram Access Token Generator – HHTV</title>

    <link rel="icon" type="image/png" href="images/favicon.png">

    <meta name="description" content="Quickly generate an access token for Instagram to display your photos on your website.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="Instagram Access Token Generator">
    <meta property="og:type" content="website">
    <meta property="og:image" content="http://instagram.pixelunion.net/images/instagram-camera-icon.png">
    <meta property="og:url" content="http://instagram.pixelunion.net">
    <meta property="og:description" content="Quickly generate an access token for Instagram to display your photos on your website.">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="http://instagram.pixelunion.net">
    <meta name="twitter:title" content="Instagram Access Token Generator">
    <meta name="twitter:description" content="Quickly generate an access token for Instagram to display your photos on your website.">
    <meta name="twitter:image" content="http://instagram.pixelunion.net/images/instagram-camera-icon.png">
    <link rel="stylesheet" href="{{ asset('/vendor/shopify/instagram/css/css.css') }}" />
    <script src="{{ asset('/vendor/shopify/instagram/js/modernizr-2.8.3.js') }}"></script>
</head>
<body>

<div class="site-header-wrapper">
    <header class="site-header" role="banner">
        <img class="logo" alt="HHTV Logo" src="images/pixel-union-logo.svg" data-backup-png="images/pixel-union-logo.png">

        <nav class="site-navigation" role="navigation">
            <a href="https://www.pixelunion.net/pixel-union-themes/">Themes</a>
            <a href="https://www.pixelunion.net/support">Support</a>
            <a href="http://pixelunion.net/blog">Blog</a>
        </nav>
    </header>
</div>

<div class="site-content-wrapper">
    <div class="site-content" role="main">

        <div class="pre-token">
            <h2><img class="instagram-camera-icon" alt="Instagram Camera Icon" src="{{ asset('/vendor/shopify/instagram/images/instagram-icon.png') }}"> Get Your Instagram Access Token</h2>

            <p>In order to display your Instagram photos on your own website, you are required to provide an Instagram Access Token. You can do this by clicking the generator button below. After clicking, you'll be prompted by Instagram to authorize HHTV to access your Instagram photos, and you may need to enter your Instagram login credentials.</p>

            <div class="token-button-wrapper">
                <a href="https://api.instagram.com/oauth/authorize/?client_id=bbff81be5157456fa21f093dbf4a24b7&redirect_uri=http://localhost/shopify/public/get-token&response_type=token" class="button" title="Generate Instagram Access Token">Generate Access Token</a>
            </div>

            <p>You'll be brought right back here and, if all went well, your Instagram Access Token will be ready for you. Copy and paste this access token into the correct field. Remember to keep your access token private and never paste it in a location where others might can access it.</p>

            <div class="section-divider">
                <h5>Frequently Asked Questions</h5>
            </div>

            <h3>What's an Instagram Access Token?</h3>

            <p>The Instagram Access Token is a long string of characters unique to your account that grants other applications access to your Instagram feed.</p>

            <h3>Why do I need a token?</h3>

            <p>Without the token, your website will be unable to talk to the Instagram servers. The token provides a secure way for a website to ask Instagram's permission to access your profile and display its images.</p>

            <h3>Why should I trust you with my token?</h3>

            <p><a href="https://www.pixelunion.net">HHTV</a> is just the company that made this tool to generate your token. We do not have access to your Instagram tokens, nor do we intend to use them or your photos for any purpose.</p>
        </div>

        <div class="post-token">
            <h2>It worked!</h2>

            <p>Use this token in the appropriate field on your website or blog, and you should have a working Instagram widget.</p>

            <div class="token-input-wrapper">
                <input class="instagram-access-token" type="text" value="" size="50">
            </div>

            <p>If you're having problems using your token, get in contact with the service that set up the theme or template you're using for your website. If you're using a <a href="https://www.pixelunion.net/themes">HHTV theme</a>, our <a href="https://www.pixelunion.net/support">customer support team</a> would be happy to help!</p>
        </div>
    </div>
</div>

<div class="site-footer-wrapper">
    <footer class="site-footer">
        <p>&copy; <script>document.write(new Date().getFullYear())</script> <a href="https://www.pixelunion.net">HHTV</a></p>
        <p>
            <a href="https://www.pixelunion.net/shopify-themes/">Shopify Themes</a>
            <span class="sep">&bull;</span>
            <a href="https://www.pixelunion.net/bigcommerce-themes/">BigCommerce Themes</a>
            <span class="sep">&bull;</span>
            <a href="https://www.pixelunion.net/apps">Ecommerce Apps</a>
        </p>
    </footer>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>window.jQuery || document.write("<script src='scripts/jquery-1.11.1.min.js'><\/script>")</script>
<script src="{{ asset('/vendor/shopify/instagram/js/shopify-app.js') }}"></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-134258-43', 'auto');
    ga('send', 'pageview');
</script>

</body>
</html>