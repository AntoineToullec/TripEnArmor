
const mapData = window.mapConfig;

var map = L.map("map").setView(mapData.center, mapData.zoom);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
	attribution: "&copy; OpenStreetMap contributors",
}).addTo(map);

var clusterGroup = L.markerClusterGroup();

// Ajouter l’offre sélectionnée UNIQUEMENT si elle existe
if (mapData.selectedOffer && mapData.selectedOffer.lat && mapData.selectedOffer.lng) {
	var selectedMarker = L.marker([mapData.selectedOffer.lat, mapData.selectedOffer.lng])
		.bindPopup(`<strong>${mapData.selectedOffer.name}</strong>`)
		.addTo(map); // On l'ajoute directement à la carte (hors cluster)

	// Ajuster le zoom pour bien voir l’offre
	map.setView([mapData.selectedOffer.lat, mapData.selectedOffer.lng], 14);
}

// Charger les autres offres via AJAX
fetch("/api/get_offers.php")
	.then(response => response.json())
	.then(data => {
		data.forEach(offer => {
			// Vérifier qu’on n’ajoute pas l’offre déjà affichée
			if (!mapData.selectedOffer || offer.id_offre !== mapData.selectedOffer.id) {
				if (offer.adresse && offer.adresse.lat && offer.adresse.lng) {
					var marker = L.marker([offer.adresse.lat, offer.adresse.lng])
						.bindPopup(`
							<strong>${offer.titre}</strong><br>
							${offer.resume}<br>
							<a href="/scripts/go_to_details.php?id_offre=${offer.id_offre}" target="_blank">Voir l'offre</a>
						`);
					clusterGroup.addLayer(marker);
				}
			}
		});

		map.addLayer(clusterGroup);
	})
	.catch(error => console.error("Erreur lors du chargement des offres :", error));

function hideMarkerWithId(id) {
	console.log(clusterGroup);
	clusterGroup.eachLayer(layer => {
		console.log("je suis dans le eachLayer");
		if (layer.getPopup()) {
			const popupContent = layer.getPopup().getContent();
			if (popupContent.includes(`id_offre=${id}`)) {
				clusterGroup.removeLayer(layer);
				console.log("Marker hidden with id:", id);
			}
		}
	});
}

function showMarkerWithId(id) {
	console.log(clusterGroup);
	clusterGroup.eachLayer(layer => {
		console.log(layer);
		if (layer.getPopup()) {
			const popupContent = layer.getPopup().getContent();
			if (popupContent.includes(`id_offre=${id}`)) {
				map.addLayer(layer);
				console.log("after showMarkerWithId", id);
			}
		}
	});
}

