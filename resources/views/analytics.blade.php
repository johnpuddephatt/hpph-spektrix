 @if ($settings['google_analytics'])
     <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics'] }}"></script>
     <script>
         window.dataLayer = window.dataLayer || [];

         function gtag() {
             dataLayer.push(arguments);
         }
         gtag('js', new Date());

         gtag('config', "{{ $settings['google_analytics'] }}");
     </script>
 @endif
