self.addEventListener('install', function(e) {
	e.waitUntil(
		caches.open('wordpress').then(function(cache) {
			return cache.addAll([
				''
      ]);
		})
  );
  console.log('install done');
});

self.addEventListener('fetch', function(event) {
	event.respondWith(
		caches.match(event.request).then(function(response) {
			return response || fetch(event.request);
		})
	);
});