
// Put an item in a specified cache
var stashInCache = function (cacheName, request, response) {
	caches.open(cacheName)
		.then(function (cache) {
			cache.put(request, response);
		});
};

self.addEventListener('fetch', function (event) {
	var request = event.request;
	// For non-GET requests, try the network first, fall back to the offline page
	if (event.request.method !== 'GET') {
		event.respondWith(
			fetch(request)
				.catch(function () {
					return caches.match('offline.html');
				})
		);
		return;
	}
	
	// For HTML requests, try the network first, fall back to the cache, finally the offline page
	//if (request.headers.get('Accept').indexOf('text/html') !== -1) {
		// Fix for Chrome bug: https://code.google.com/p/chromium/issues/detail?id=573937
		if (request.mode !== 'navigate') {
			request = new Request(request.url, {
				method: 'GET',
				headers: request.headers,
				mode: request.mode,
				credentials: request.credentials,
				redirect: request.redirect
			});
		}
		event.respondWith(
			fetch(request)
				.then(function (response) {
					// NETWORK
					// Stash a copy of this page in the pages cache
					var copy = response.clone();
					stashInCache('wordpress-free', request, copy);
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