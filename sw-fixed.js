self.addEventListener('install', function(event) {
	event.waitUntil(
		caches.open('wordpress-fixed').then(function(cache) {
			return cache.addAll([
				'/wordpress/',
				'/wordpress/wp-content/themes/twentynineteen/print.css',
				'/wordpress/wp-content/themes/twentynineteen/style.css',
				'/wordpress/wp-includes/css/dist/block-library/style.min.css',
				'/wordpress/wp-includes/css/dist/block-library/theme.min.css',
				'/wordpress/wp-includes/js/wp-embed.min.js',
				'/wordpress/wp-includes/js/wp-emoji-release.min.js',
				'/wordpress/offline.html'
      ]);
		})
  );
  console.log('install done');
});

self.addEventListener('fetch', function(event) {
	//console.log(event.request.url);
	console.log(caches.has('wordpress-fixed'));
	var request = event.request;
	if (event.request.url.match('wp-admin/') || event.request.url.match('preview=true')) {
		console.log('Admin');
		return;
	}
	event.respondWith(
		fetch(request)
			.then(function (response) {
				// NETWORK
				//console.log(response);
				return response;
			})
			.catch(function () {
				// CACHE or FALLBACK
				return caches.match(request)
					.then(function (response) {
						return response || caches.match('/wordpress/offline.html');
					})
			})
	);
});