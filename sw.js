const CACHE_NAME = 'forca-pro-v1.0.0';
const STATIC_ASSETS = [
  './',
  './index.php',
  './words.json',
  './manifest.json',
  './favicon.svg',
  './favicon-32x32.png',
  './icon-192.png',
  './icon-512.png',
  './privacidade.php',
  './termos.php',
  './suporte.php'
];

self.addEventListener('install', (e) => {
  e.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(STATIC_ASSETS);
    }).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (e) => {
  e.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys.map((k) => {
          if (k !== CACHE_NAME) {
            return caches.delete(k);
          }
        })
      );
    }).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (e) => {
  const url = new URL(e.request.url);

  // Somente lidar com requisições do mesmo domínio ou recursos estáticos locais
  if (e.request.method !== 'GET') return;

  if (url.origin === location.origin && (url.pathname.endsWith('.json') || url.pathname.endsWith('.svg') || url.pathname.endsWith('.png'))) {
    e.respondWith(
      caches.match(e.request).then((cached) => {
        return cached || fetch(e.request).then((resp) => {
          if (resp && resp.status === 200) {
            const copy = resp.clone();
            caches.open(CACHE_NAME).then((cache) => cache.put(e.request, copy));
          }
          return resp;
        });
      })
    );
    return;
  }

  // Network first para navegação, fallback para cache
  e.respondWith(
    fetch(e.request)
      .then((networkResp) => {
        if (networkResp && networkResp.status === 200) {
          const respCopy = networkResp.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(e.request, respCopy));
        }
        return networkResp;
      })
      .catch(() => caches.match(e.request))
  );
});
