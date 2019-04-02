self.addEventListener("fetch", function(event) {
  //This service worker won't touch the admin area and preview pages
  if (event.request.url.match('wp-login')) {
		  caches.open('wordpress').then(function(cache) {
			  return cache.addAll([
				  'wp-login.php'
			  ]);
		  });
	  console.log('wp-login added');
  }
});

self.addEventListener('fetch', function(event) {
	event.respondWith(
		caches.match(event.request).then(function(response) {
			return response || fetch(event.request);
		})
	);
});
/*self.addEventListener("fetch", function(event) {
	//This service worker won't touch the admin area and preview pages
	if (event.request.url.match(/wp-admin/) || event.request.url.match(/preview=true/)) {
		return;
	}
});*/

/*self.addEventListener('fetch', function(event) {
	//console.log(event.request.url);
	
	event.respondWith(
		caches.match(event.request).then(function(response) {
			return response || fetch(event.request);
		})
	);
});

self.addEventListener('notificationclick', function(e){
    e.waitUntil(
		caches.open('wordpress').then(function(cache) {
			return cache.addAll([
				'/',
                '/wordpress/wp-login.php',
                '/wordpress/wp-config.php'
            ]);
		})
    );
    console.log('click registered');
});*/

/*self.addEventListener('event', function(e){
	e.
});*/