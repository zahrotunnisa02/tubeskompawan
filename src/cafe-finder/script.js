// Inisialisasi Peta
const map = L.map('map').setView([-6.200000, 106.816666], 13); // Default: Jakarta

// Tambahkan Tile Layer dari OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '© OpenStreetMap'
}).addTo(map);

// Fungsi untuk Menghitung Jarak (Haversine Formula)
function calculateDistance(lat1, lon1, lat2, lon2) {
  const R = 6371; // Radius bumi dalam kilometer
  const dLat = (lat2 - lat1) * (Math.PI / 180);
  const dLon = (lon2 - lon1) * (Math.PI / 180);
  const a =
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(lat1 * (Math.PI / 180)) *
      Math.cos(lat2 * (Math.PI / 180)) *
      Math.sin(dLon / 2) *
      Math.sin(dLon / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  return R * c; // Jarak dalam kilometer
}
// Fungsi untuk Menampilkan Kafe dari Daftar
function displayCafes(location) {
  const [userLat, userLon] = location;
  const radius = 2; // Radius dalam kilometer
  const cafeList = document.getElementById('cafeList');
  cafeList.innerHTML = ''; // Hapus daftar sebelumnya

  // Ambil data kafe dari API
  fetch('get_cafes.php') // Mengambil data kafe dari API PHP
    .then(response => response.json())
    .then(cafes => {
      // Filter kafe berdasarkan radius
      const nearbyCafes = cafes.filter(cafe => {
        const distance = calculateDistance(userLat, userLon, cafe.latitude, cafe.longitude);
        cafe.distance = distance; // Simpan jarak
        return distance <= radius; // Ambil kafe dalam radius
      });

      // Jika tidak ada kafe yang ditemukan
      if (nearbyCafes.length === 0) {
        cafeList.innerHTML = '<li>Tidak ada kafe dalam radius 2 km.</li>';
        return;
      }

      // Tambahkan Kafe ke Peta dan Daftar
      nearbyCafes.forEach(cafe => {
        // Tambahkan Marker ke Peta
        const marker = L.marker([cafe.latitude, cafe.longitude])
          .addTo(map)
          .bindPopup(` 
            <b>${cafe.name}</b><br>
            Deskripsi: ${cafe.description || 'Deskripsi tidak tersedia.'}<br>
            Jarak: ${cafe.distance.toFixed(2)} km<br>
            <img src="${cafe.image_url}" alt="${cafe.name}" style="width: 100px; height: auto; margin-top: 10px;" /><br>
            <a href="detail_cafe.php?id=${cafe.id}" class="btn btn-primary mt-2" target="_blank">Lihat Detail</a>
          `);

        // Tambahkan Kafe ke Daftar
        const li = document.createElement('li');
        li.innerHTML = `<strong>${cafe.name}</strong> - ${cafe.distance.toFixed(2)} km`;
        li.style.cursor = 'pointer';
        li.addEventListener('click', () => {
          map.setView([cafe.latitude, cafe.longitude], 15); // Fokus ke lokasi kafe
          marker.openPopup(); // Tampilkan popup dengan deskripsi kafe
        });
        cafeList.appendChild(li);
      });
    })
    .catch(error => {
      console.error('Error fetching cafes:', error);
      cafeList.innerHTML = '<li>Gagal memuat daftar kafe.</li>';
    });
}
// Fungsi untuk Menggunakan Lokasi Saat Ini
function useCurrentLocation() {
  if (!navigator.geolocation) {
    alert('Geolokasi tidak didukung oleh browser Anda.');
    return;
  }

  navigator.geolocation.getCurrentPosition(
    (position) => {
      const userLocation = [position.coords.latitude, position.coords.longitude];
      map.setView(userLocation, 15); // Pindahkan peta ke lokasi pengguna
      L.marker(userLocation).addTo(map).bindPopup('Lokasi Anda').openPopup();
      displayCafes(userLocation); // Tampilkan kafe berdasarkan lokasi pengguna
    },
    (error) => {
      alert('Gagal mendapatkan lokasi Anda. Silakan coba lagi.');
      console.error('Geolocation error:', error);
    }
  );
}

// Event Listener untuk Tombol "Gunakan Lokasi Saya"
document.getElementById('currentLocationButton').addEventListener('click', () => {
  const button = document.getElementById('currentLocationButton');
  button.textContent = 'Mencari Lokasi...';
  button.disabled = true;

  useCurrentLocation();

  setTimeout(() => {
    button.textContent = 'Gunakan Lokasi Saya';
    button.disabled = false;
  }, 3000); // Reset setelah 3 detik
});

// Event Listener untuk Tombol "Cari Lokasi"
document.getElementById('searchButton').addEventListener('click', () => {
  const location = document.getElementById('locationInput').value;
  if (!location) {
    alert('Silakan masukkan lokasi.');
    return;
  }

  // Geocoding untuk Mendapatkan Koordinat dari Nama Lokasi
  fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(location)}`)
    .then(response => response.json())
    .then(data => {
      if (data.length === 0) {
        alert('Lokasi tidak ditemukan.');
        return;
      }

      const { lat, lon } = data[0];
      const userLocation = [parseFloat(lat), parseFloat(lon)];
      map.setView(userLocation, 15); // Pindahkan peta ke lokasi yang dicari
      L.marker(userLocation).addTo(map).bindPopup(`Lokasi: ${location}`).openPopup();
      displayCafes(userLocation); // Tampilkan kafe berdasarkan lokasi yang dicari
    });
});
