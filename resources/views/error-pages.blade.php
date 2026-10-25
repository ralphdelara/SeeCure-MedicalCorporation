<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex" />
    <title>@yield('error-title')</title>
    <link rel="stylesheet" href="{{ asset('css/error-pages.css') }}">
  </head>
  <body>
    <main>
      <section class="card">
        <div class="seal" role="img" aria-label="SEE CURE Medical Corporation emblem"><div></div></div>
        <div class="code" aria-hidden="true">@yield('error-code')</div>
        <svg class="pulse" viewBox="0 0 400 48" aria-hidden="true">
          <path d="M0 28 H130 L146 18 L160 28 H178 L192 4 L208 46 L222 22 H400" />
        </svg>
        <h1>@yield('error-header')</h1>
        <p>@yield('error-message')</p>
        <div class="actions">
          <a class="btn primary" href="/">Go to home page</a>
        </div>
      </section>
    </main>
    <footer><strong>SEE CURE</strong> Medical Corporation</footer>
  </body>
</html>
