@if(Config::get('app.showStream'))  {{-- Don't show ads for dev pages --}}
<div class="ad horizontal">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Twitch Random Responsive Ad - Horizontal 2 -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-1737596577801120"
         data-ad-slot="7956771146"
         data-ad-format="auto"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
@endif