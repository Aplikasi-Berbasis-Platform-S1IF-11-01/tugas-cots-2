const express = require('express');
const bodyParser = require('body-parser');
const { v4: uuidv4 } = require('uuid');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;
const DATA_FILE = path.join(__dirname, 'data', 'mahasiswa.json');

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

function readData() {
  try { return JSON.parse(fs.readFileSync(DATA_FILE, 'utf-8')); }
  catch { return []; }
}
function writeData(data) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2), 'utf-8');
}

function hitungStatistik(data) {
  if (!data.length) return { avg:'0.00', min:'0.00', max:'0.00', median:'0.00', total:0, distribusi:{}, perJurusan:[], top5:[], statusDist:{} };
  const ipks = data.map(m => m.ipk).sort((a, b) => a - b);
  const total = data.length;
  const avg = (ipks.reduce((s,v)=>s+v,0)/total).toFixed(2);
  const mid = Math.floor(total/2);
  const median = (total%2===0 ? (ipks[mid-1]+ipks[mid])/2 : ipks[mid]).toFixed(2);
  const distribusi = {
    'Di Bawah Standar (< 2.00)':             data.filter(m=>m.ipk<2.00).length,
    'Memuaskan (2.00–2.74)':                 data.filter(m=>m.ipk>=2.00&&m.ipk<2.75).length,
    'Sangat Memuaskan (2.75–3.49)':          data.filter(m=>m.ipk>=2.75&&m.ipk<3.50).length,
    'Dengan Pujian / Cumlaude (3.50–4.00)':  data.filter(m=>m.ipk>=3.50).length,
  };
  const jMap = {};
  data.forEach(m => {
    if (!jMap[m.jurusan]) jMap[m.jurusan] = {sum:0,count:0};
    jMap[m.jurusan].sum += m.ipk;
    jMap[m.jurusan].count++;
  });
  const perJurusan = Object.entries(jMap)
    .map(([nama,v]) => ({nama, avg:(v.sum/v.count).toFixed(2), count:v.count}))
    .sort((a,b)=>b.avg-a.avg);
  const top5 = [...data].sort((a,b)=>b.ipk-a.ipk).slice(0,5);
  const statusDist = {
    Aktif: data.filter(m=>m.status==='Aktif').length,
    Cuti:  data.filter(m=>m.status==='Cuti').length,
    Lulus: data.filter(m=>m.status==='Lulus').length,
  };
  return { avg, min:ipks[0].toFixed(2), max:ipks[total-1].toFixed(2), median, total, distribusi, perJurusan, top5, statusDist };
}

// ─── PAGE ROUTES ──
app.get('/', (req, res) => {
  const data = readData();
  const stats = {
    total: data.length,
    aktif: data.filter(m=>m.status==='Aktif').length,
    cuti:  data.filter(m=>m.status==='Cuti').length,
    avgIpk: data.length ? (data.reduce((s,m)=>s+m.ipk,0)/data.length).toFixed(2) : 0
  };
  res.render('index', { title:'Data Mahasiswa', stats });
});

app.get('/tambah', (req, res) => res.render('form', { title:'Tambah Mahasiswa', mahasiswa:null, action:'/tambah', method:'POST' }));

app.get('/edit/:id', (req, res) => {
  const data = readData();
  const mahasiswa = data.find(m=>m.id===req.params.id);
  if (!mahasiswa) return res.redirect('/?error=not_found');
  res.render('form', { title:'Edit Mahasiswa', mahasiswa, action:`/edit/${mahasiswa.id}`, method:'POST' });
});

app.get('/detail/:id', (req, res) => {
  const data = readData();
  const mahasiswa = data.find(m=>m.id===req.params.id);
  if (!mahasiswa) return res.redirect('/?error=not_found');
  res.render('detail', { title:'Detail Mahasiswa', mahasiswa });
});

// ─── STATISTIK ──
app.get('/statistik', (req, res) => {
  const data = readData();
  const stats = hitungStatistik(data);
  res.render('statistik', { title:'Statistik IPK', stats, totalData:data.length });
});

// ─── EKSPOR PAGE ──
app.get('/ekspor', (req, res) => {
  const data = readData();
  const jurusanList = [...new Set(data.map(m=>m.jurusan))].sort();
  res.render('ekspor', { title:'Ekspor Laporan', jurusanList, totalData:data.length });
});

// ─── EKSPOR CSV ──
app.get('/ekspor/csv', (req, res) => {
  let data = readData();
  if (req.query.jurusan) data = data.filter(m=>m.jurusan===req.query.jurusan);
  if (req.query.status)  data = data.filter(m=>m.status===req.query.status);
  const header = ['No','NIM','Nama','Jurusan','Semester','IPK','Email','Status','Tanggal Daftar'];
  const rows = data.map((m,i) => [i+1, m.nim, m.nama, m.jurusan, m.semester, m.ipk.toFixed(2), m.email, m.status, m.createdAt]);
  const csv = '\uFEFF' + [header,...rows].map(r => r.map(v=>`"${String(v).replace(/"/g,'""')}"`).join(',')).join('\r\n');
  res.setHeader('Content-Type','text/csv; charset=utf-8');
  res.setHeader('Content-Disposition',`attachment; filename="laporan-mahasiswa-${Date.now()}.csv"`);
  res.send(csv);
});

// ─── EKSPOR EXCEL ──
app.get('/ekspor/excel', (req, res) => {
  let XLSX;
  try { XLSX = require('xlsx'); } catch { return res.status(500).send('Jalankan: npm install xlsx'); }
  let data = readData();
  if (req.query.jurusan) data = data.filter(m=>m.jurusan===req.query.jurusan);
  if (req.query.status)  data = data.filter(m=>m.status===req.query.status);

  const rows = data.map((m,i) => ({
    'No': i+1, 'NIM': m.nim, 'Nama Mahasiswa': m.nama,
    'Jurusan': m.jurusan, 'Semester': m.semester,
    'IPK': parseFloat(m.ipk.toFixed(2)), 'Email': m.email,
    'Status': m.status, 'Tanggal Daftar': m.createdAt,
  }));
  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.json_to_sheet(rows);
  ws['!cols'] = [{wch:5},{wch:14},{wch:24},{wch:24},{wch:10},{wch:8},{wch:32},{wch:10},{wch:14}];
  XLSX.utils.book_append_sheet(wb, ws, 'Data Mahasiswa');

  const s = hitungStatistik(data);
  const ws2 = XLSX.utils.json_to_sheet([
    {'Keterangan':'Total Mahasiswa','Nilai':data.length},
    {'Keterangan':'Rata-rata IPK','Nilai':s.avg},
    {'Keterangan':'IPK Tertinggi','Nilai':s.max},
    {'Keterangan':'IPK Terendah','Nilai':s.min},
    {'Keterangan':'Median IPK','Nilai':s.median},
  ]);
  ws2['!cols'] = [{wch:22},{wch:12}];
  XLSX.utils.book_append_sheet(wb, ws2, 'Statistik');

  const buf = XLSX.write(wb, {type:'buffer', bookType:'xlsx'});
  res.setHeader('Content-Type','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  res.setHeader('Content-Disposition',`attachment; filename="laporan-mahasiswa-${Date.now()}.xlsx"`);
  res.send(buf);
});

// ─── EKSPOR PDF ──
app.get('/ekspor/pdf', (req, res) => {
  let PDFDocument;
  try { PDFDocument = require('pdfkit'); } catch { return res.status(500).send('Jalankan: npm install pdfkit'); }
  let data = readData();
  if (req.query.jurusan) data = data.filter(m=>m.jurusan===req.query.jurusan);
  if (req.query.status)  data = data.filter(m=>m.status===req.query.status);
  const s = hitungStatistik(data);

  const doc = new PDFDocument({ margin:45, size:'A4', layout:'landscape' });
  res.setHeader('Content-Type','application/pdf');
  res.setHeader('Content-Disposition',`attachment; filename="laporan-mahasiswa-${Date.now()}.pdf"`);
  doc.pipe(res);

  // Header banner
  doc.rect(0,0,doc.page.width,65).fill('#4361ee');
  doc.fill('#fff').fontSize(18).font('Helvetica-Bold').text('LAPORAN DATA MAHASISWA', 45, 18);
  doc.fontSize(9).font('Helvetica').text('SIAKAD — Sistem Informasi Akademik', 45, 40);
  doc.text(`Dicetak: ${new Date().toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'})}`, doc.page.width-220, 40, {width:175, align:'right'});

  // Stat boxes
  doc.fill('#334155').fontSize(10).font('Helvetica-Bold').text('RINGKASAN STATISTIK', 45, 82);
  const boxes = [['Total Data',data.length],['Rata-rata IPK',s.avg],['IPK Tertinggi',s.max],['IPK Terendah',s.min],['Median IPK',s.median]];
  const bw=135, bh=42;
  boxes.forEach(([lbl,val],i) => {
    const bx = 45 + i*(bw+8);
    doc.roundedRect(bx,97,bw,bh,4).fill('#eef2ff');
    doc.fill('#4361ee').fontSize(15).font('Helvetica-Bold').text(String(val),bx+7,104,{width:bw-14});
    doc.fill('#64748b').fontSize(7.5).font('Helvetica').text(lbl,bx+7,121,{width:bw-14});
  });

  // Table
  const tTop=158, cols=[
    {l:'No',w:28,a:'center'},{l:'NIM',w:88,a:'left'},{l:'Nama Mahasiswa',w:148,a:'left'},
    {l:'Jurusan',w:140,a:'left'},{l:'Sem',w:32,a:'center'},{l:'IPK',w:42,a:'center'},
    {l:'Status',w:58,a:'center'},{l:'Tgl Daftar',w:76,a:'center'},
  ];
  const tW = cols.reduce((s,c)=>s+c.w,0);

  doc.rect(45,tTop,tW,20).fill('#4361ee');
  let cx=45;
  cols.forEach(c=>{
    doc.fill('#fff').fontSize(8).font('Helvetica-Bold').text(c.l,cx+3,tTop+6,{width:c.w-6,align:c.a});
    cx+=c.w;
  });

  let ry=tTop+20;
  data.forEach((m,i)=>{
    if(ry>doc.page.height-50){
      doc.addPage();
      ry=45;
      // re-draw header
      doc.rect(45,ry,tW,20).fill('#4361ee');
      let cx2=45;
      cols.forEach(c=>{
        doc.fill('#fff').fontSize(8).font('Helvetica-Bold').text(c.l,cx2+3,ry+6,{width:c.w-6,align:c.a});
        cx2+=c.w;
      });
      ry+=20;
    }
    const rh=16;
    doc.rect(45,ry,tW,rh).fill(i%2===0?'#f8f9ff':'#fff');
    const row=[i+1,m.nim,m.nama,m.jurusan,`Sem ${m.semester}`,m.ipk.toFixed(2),m.status,m.createdAt];
    let rx2=45;
    row.forEach((v,ci)=>{
      let fc='#1e293b';
      if(ci===5){const n=parseFloat(v);fc=n>=3.5?'#059669':n>=3.0?'#2563eb':n>=2.0?'#d97706':'#dc2626';}
      doc.fill(fc).fontSize(7.5).font(ci===5?'Helvetica-Bold':'Helvetica')
         .text(String(v),rx2+3,ry+4,{width:cols[ci].w-6,align:cols[ci].a});
      rx2+=cols[ci].w;
    });
    ry+=rh;
  });
  doc.moveTo(45,ry).lineTo(45+tW,ry).strokeColor('#cbd5e1').lineWidth(0.5).stroke();

  // Footer
  doc.fill('#94a3b8').fontSize(7.5).font('Helvetica')
     .text(`SIAKAD — Sistem Informasi Akademik  |  Total: ${data.length} mahasiswa`,
           45,doc.page.height-25,{align:'center',width:doc.page.width-90});
  doc.end();
});

// ─── API ROUTES ──
app.get('/api/mahasiswa', (req, res) => res.json({ data: readData() }));
app.get('/api/mahasiswa/:id', (req, res) => {
  const m = readData().find(m=>m.id===req.params.id);
  if (!m) return res.status(404).json({success:false,message:'Tidak ditemukan'});
  res.json({success:true,data:m});
});
app.get('/api/statistik', (req, res) => res.json(hitungStatistik(readData())));

app.post('/tambah', (req, res) => {
  const data = readData();
  const { nim, nama, jurusan, semester, ipk, email, status } = req.body;
  if (data.find(m=>m.nim===nim)) return res.render('form',{title:'Tambah Mahasiswa',mahasiswa:req.body,action:'/tambah',method:'POST',error:`NIM ${nim} sudah terdaftar!`});
  data.push({ id:`mhs-${uuidv4().slice(0,8)}`, nim:nim.trim(), nama:nama.trim(), jurusan:jurusan.trim(), semester:parseInt(semester), ipk:parseFloat(ipk), email:email.trim(), status:status||'Aktif', createdAt:new Date().toISOString().slice(0,10) });
  writeData(data);
  res.redirect('/?success=tambah');
});

app.post('/edit/:id', (req, res) => {
  const data = readData();
  const idx = data.findIndex(m=>m.id===req.params.id);
  if (idx===-1) return res.redirect('/?error=not_found');
  const { nim, nama, jurusan, semester, ipk, email, status } = req.body;
  if (data.find(m=>m.nim===nim&&m.id!==req.params.id)) return res.render('form',{title:'Edit Mahasiswa',mahasiswa:{...data[idx],...req.body},action:`/edit/${req.params.id}`,method:'POST',error:`NIM ${nim} sudah digunakan!`});
  data[idx] = {...data[idx], nim:nim.trim(), nama:nama.trim(), jurusan:jurusan.trim(), semester:parseInt(semester), ipk:parseFloat(ipk), email:email.trim(), status:status||'Aktif'};
  writeData(data);
  res.redirect('/?success=edit');
});

app.delete('/api/mahasiswa/:id', (req, res) => {
  const data = readData();
  const idx = data.findIndex(m=>m.id===req.params.id);
  if (idx===-1) return res.status(404).json({success:false,message:'Tidak ditemukan'});
  const deleted = data.splice(idx,1)[0];
  writeData(data);
  res.json({success:true,message:`Data ${deleted.nama} berhasil dihapus`});
});

app.listen(PORT, () => {
  console.log(`\n🎓 Aplikasi berjalan di: http://localhost:${PORT}\n`);
});
