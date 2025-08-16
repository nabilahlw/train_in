// ===== DATA DUMMY (bisa diganti fetch dari PHP nantinya) =====
const trains = [
  {id:1,name:'Argo Bromo',route:'Jakarta – Surabaya',time:'08:00 • 15:30',price:350000,img:'img/train1.jpg'},
  {id:2,name:'Lodaya',route:'Bandung – Yogyakarta',time:'07:00 • 13:15',price:280000,img:'img/train2.jpg'},
  {id:3,name:'Taksaka',route:'Yogyakarta – Jakarta',time:'09:00 • 15:00',price:300000,img:'img/train3.jpg'},
  {id:4,name:'Kertajaya',route:'Surabaya – Semarang',time:'06:30 • 11:45',price:220000,img:'img/train4.jpg'},
  {id:5,name:'Argo Lawu',route:'Solo – Jakarta',time:'20:00 • 04:30',price:340000,img:'img/train5.jpg'},
  {id:6,name:'Matarmaja',route:'Malang – Jakarta',time:'10:00 • 19:30',price:250000,img:'img/train6.jpg'}
];

const form = document.getElementById('searchForm');
const resultSection = document.getElementById('resultSection');
const cardContainer = document.getElementById('cardContainer');

form.addEventListener('submit', e=>{
  e.preventDefault(); // stop form reload
  renderCards();       // tampilkan kartu
  resultSection.classList.remove('hidden');
});

function renderCards(){
  cardContainer.innerHTML = '';

  // Ambil nilai penumpang dari form
  const penumpang = document.querySelector('select[name="penumpang"]').value;

  // Generate kartu
  trains.forEach(t => {
    cardContainer.innerHTML += `
      <div class="card">
        <img src="${t.img}" alt="${t.name}">
        <div class="card-body">
          <h3>${t.name}</h3>
          <p>${t.route}</p>
          <p style="font-size:15px;">${t.time}</p>
          <p class="price">Rp ${t.price.toLocaleString('id-ID')}</p>
          <a class="btn" href="pesan.php?id=${t.id}&p=${penumpang}">Pesan</a>
        </div>
      </div>
    `;
  });
}
