<!doctype html>
<html lang="en">
<head>
  <title>CSDL | IEEE Computer Society</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <link rel="stylesheet" href="https://d20lqhyll7kadk.cloudfront.net/apps/csdl-website/assets/css/bootstrap.css">
  <link rel="icon" href="https://ieeecs-media.computer.org/wp-media/2018/04/27230619/cropped-cs-favicon-512x512-32x32.png"sizes="32x32">
  <meta name="google-site-verification" content="jxkhBtaf9VsFL5u9dqfOQQCZDIoQdx1aiKlkQEUgAvk"/>
  <link rel="dns-prefetch" href="https://key1.computer.org">
  <link rel="dns-prefetch" href="https://services10.ieee.org">
  <link rel="stylesheet" href="https://www.computer.org/csdl/cdn/apps/csdl-website/dist/production/styles.e2a4da4360eab16c520c.css">
</head>
<base href="/csdl">
<body>
<csdl-app></csdl-app>
<!-- BEGIN GOOGLE ANALYTICS -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-381255-5"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }

  gtag('js', new Date());
  gtag('config', 'UA-381255-5', {'send_page_view': false});
</script>
<!-- BEGIN FACEBOOK ANALYTICS -->
<script>
  !function (f, b, e, v, n, t, s) {
    if (f.fbq) return;
    n = f.fbq = function () {
      n.callMethod ?
        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
    };
    if (!f._fbq) f._fbq = n;
    n.push = n;
    n.loaded = !0;
    n.version = '2.0';
    n.queue = [];
    t = b.createElement(e);
    t.async = !0;
    t.src = v;
    s = b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t, s)
  }(window, document, 'script',
    'https://connect.facebook.net/en_US/fbevents.js');
</script>
<!-- END FACEBOOK ANALYTICS -->
<script>
  // The following function allows an article to have click-able reference
  // links that will scroll to the 'References' section of the article
  // and highlight the appropriate reference
  function scrollToReference(referenceNum) {
    var refQuery = '#' + referenceNum;
    $('html, body').animate({
      scrollTop: $(refQuery).offset().top,
    }, 1000);
    $('ul.referencesNotesList').children()
      .css('background', 'inherit');
    $(refQuery).parent('li')
      .css('background', '#ffffd1');
  }

  // When the user scrolls down 20px from the top of the document, show the
  // scroll-to-top button
  window.onscroll = function () {
    scrollFunction()
  };

  function scrollFunction() {
    const scrollToTopLink = document.getElementById('scrollToTopLink');
    if (scrollToTopLink) {
      if (document.body.scrollTop > 600 ||
        document.documentElement.scrollTop > 600) {
        scrollToTopLink.style.display = 'block';
      } else {
        scrollToTopLink.style.display = 'none';
      }
    }
  }

  // When the user clicks on the button, scroll to the top of the document
  function scrollToTopOfPage() {
    $('html, body').animate({
      scrollTop: $('html').offset().top,
    }, 1000);
  }
</script>

<!-- Begin Feathr script -->
<script>
  !function(f,e,a,t,h,r){if(!f[h]){r=f[h]=function(){r.invoke?
    r.invoke.apply(r,arguments):r.queue.push(arguments)},
    r.queue=[],r.loaded=1*new Date,r.version="1.0.0",
    f.FeathrBoomerang=r;var g=e.createElement(a),
    h=e.getElementsByTagName("head")[0]||e.getElementsByTagName("script")[0].parentNode;
    g.async=!0,g.src=t,h.appendChild(g)}
  }(window,document,"script","https://cdn.feathr.co/js/boomerang.min.js","feathr");
</script>
<script type="text/javascript" src="https://www.computer.org/csdl/cdn/vendor/mathjax/2.7.1/MathJax.js?config=TeX-MML-AM_CHTML-full"></script>
<script type="text/javascript">
  MathJax.Hub.Config({
    mml2jax: {
      preview: "none"
    },
    tex2jax: {
      inlineMath: [
        ['$_$','$_$'],
        ['\\(','\\)'],
        ['__$','$__'],
        ['$$','$$'],
        ['Z_$','$_Z'],
      ]
    },
    showProcessingMessages: false,
    messageStyle: "none",
    "fast-preview": {
      disabled: true
    },
    CommonHTML: {
      linebreaks: {
        automatic: true
      }
    },
    "HTML-CSS": {
      linebreaks: {
        automatic: true
      }
    },
    SVG: {
      linebreaks: {
        automatic: true
      }
    },
    TeX: {
      noErrors: {
        disabled: true
      }
    },
    MathMenu: {
      styles: {
        ".MathJax_Menu": {
          "z-index": 2001
        }
      },
      delay: 600
    },
    extensions: ["TeX/ieeemacros.js"],
    menuSettings: {
      zoom: "Click"
    }
  });
</script>
<script src="https://www.computer.org/csdl/cdn/apps/csdl-website/dist/production/runtime-es2015.594d7fcf68fbae12fd91.js" type="module"></script><script src="https://www.computer.org/csdl/cdn/apps/csdl-website/dist/production/runtime-es5.594d7fcf68fbae12fd91.js" nomodule defer></script><script src="https://www.computer.org/csdl/cdn/apps/csdl-website/dist/production/polyfills-es5.08a2fa1cffe960dd974f.js" nomodule defer></script><script src="https://www.computer.org/csdl/cdn/apps/csdl-website/dist/production/polyfills-es2015.6dd6fe94b2d8e6a2483e.js" type="module"></script><script src="https://www.computer.org/csdl/cdn/apps/csdl-website/dist/production/scripts.d3a1a25063efe1a04ddc.js" defer></script><script src="https://www.computer.org/csdl/cdn/apps/csdl-website/dist/production/main-es2015.f48ba7d86e5279efd916.js" type="module"></script><script src="https://www.computer.org/csdl/cdn/apps/csdl-website/dist/production/main-es5.f48ba7d86e5279efd916.js" nomodule defer></script></body>
</html>