var cacheBuster = 'CACHE_BUSTER';

self.addEventListener('install', function(e) {
	e.waitUntil(
		caches.open('wordpress').then(function(cache) {
			return cache.addAll([
				'/',
				'offline.html'
      ]);
		})
  );
  console.log('install done');
});

self.addEventListener('fetch', function(event) {
	console.log('Enters');
	if (event.request.url.match('wp-admin/') || event.request.url.match('preview=true')) {
		console.log('Admin');
		return;
	}
	event.respondWith(
		caches.match(event.request).then(function(response) {
			return response || fetch(event.request);
		})
	);
});