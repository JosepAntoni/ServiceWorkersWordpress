self.addEventListener('install', function(e) {
	e.waitUntil(
		caches.open('wordpress').then(function(cache) {
			return cache.addAll([
				'wp-login.php',
				'wp-config.php',
				'wp-includes',
				'wp-admin',
				'wp-content',
				'wp-content/themes/twentynineteen/index.php'
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