const express = require("express")
const fs = require("fs")
const app = express()

app.use(express.json())
app.use(express.static("public"))

const DB = "./data/db.json"

function readDB() {
    if (!fs.existsSync(DB)) fs.writeFileSync(DB, "[]")
    return JSON.parse(fs.readFileSync(DB))
}
function writeDB(data) {
    fs.writeFileSync(DB, JSON.stringify(data, null, 2))
}

// READ
app.get("/mahasiswa", (req, res) => {
    res.json(readDB())
})

// CREATE
app.post("/mahasiswa", (req, res) => {
    const data = readDB()
    const { nim, nama, jurusan, angkatan, email } = req.body
    if (!nim || !nama || !jurusan) return res.status(400).json({ message: "Data tidak lengkap" })
    if (data.find(m => m.nim === nim)) return res.status(400).json({ message: "NIM sudah ada" })
    data.push({ nim, nama, jurusan, angkatan, email, createdAt: new Date().toISOString() })
    writeDB(data)
    res.json({ message: "Data berhasil ditambah" })
})

// GET BY NIM
app.get("/mahasiswa/:nim", (req, res) => {
    const data = readDB()
    const mhs = data.find(m => m.nim === req.params.nim)
    if (!mhs) return res.status(404).json({ message: "Data tidak ditemukan" })
    res.json(mhs)
})

// UPDATE
app.put("/mahasiswa/:nim", (req, res) => {
    let data = readDB()
    const idx = data.findIndex(m => m.nim === req.params.nim)
    if (idx === -1) return res.status(404).json({ message: "Data tidak ditemukan" })
    data[idx] = { ...data[idx], ...req.body, nim: req.params.nim }
    writeDB(data)
    res.json({ message: "Data berhasil diupdate" })
})

// DELETE
app.delete("/mahasiswa/:nim", (req, res) => {
    let data = readDB()
    data = data.filter(m => m.nim !== req.params.nim)
    writeDB(data)
    res.json({ message: "Data berhasil dihapus" })
})

app.listen(3000, () => console.log("✅ Server jalan di http://localhost:3000"))