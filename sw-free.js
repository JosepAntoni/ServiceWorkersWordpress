
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
					stashInCache('wordpress', request, copy);
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
		return;
	//}
	
	// For non-HTML requests, look in the cache first, fall back to the network
	/*event.respondWith(
		caches.match(request)
			.then(function (response) {
				// CACHE
				return response || fetch(request)
					.then(function (response) {
						// NETWORK
						// If the request is for an image, stash a copy of this image in the images cache
						if (request.headers.get('Accept').indexOf('image') !== -1) {
							var copy = response.clone();
							stashInCache('wordpress', request, copy);
						}
						return response;
					})
					.catch(function () {
						// OFFLINE
						// If the request is for an image, show an offline placeholder
						if (request.headers.get('Accept').indexOf('image') !== -1) {
							return new Response('<svg role="img" aria-labelledby="offline-title" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg"><title id="offline-title">Offline</title><g fill="none" fill-rule="evenodd"><path fill="#D8D8D8" d="M0 0h400v300H0z"/><text fill="#9B9B9B" font-family="Helvetica Neue,Arial,Helvetica,sans-serif" font-size="72" font-weight="bold"><tspan x="93" y="172">offline</tspan></text></g></svg>', { headers: { 'Content-Type': 'image/svg+xml' }});
						}
					});
			})
	);*/
});