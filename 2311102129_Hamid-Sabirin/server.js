const express = require('express');
const cors = require('cors');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = 3000;
const DATA_FILE = path.join(__dirname, 'data.json');

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static('public')); // Serve static files

// Helper to read data
function readData() {
    if (!fs.existsSync(DATA_FILE)) {
        return [];
    }
    const data = fs.readFileSync(DATA_FILE, 'utf8');
    try {
        return JSON.parse(data);
    } catch(e) {
        return [];
    }
}

// Helper to write data
function writeData(data) {
    fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2), 'utf8');
}

// Ensure init data file exists with Products
if (!fs.existsSync(DATA_FILE)) {
    writeData([
        { id: 1, sku: "PRD-001", name: "Premium Wireless Headphones", category: "Elektronik", price: "1250000", stock: "45" },
        { id: 2, sku: "PRD-002", name: "Ergonomic Office Chair", category: "Furniture", price: "2400000", stock: "12" },
        { id: 3, sku: "PRD-003", name: "Mechanical Keyboard RGB", category: "Aksesoris Komputer", price: "850000", stock: "30" },
        { id: 4, sku: "PRD-004", name: "Smartwatch Series X", category: "Elektronik", price: "3200000", stock: "25" },
    ]);
}

// --- API Endpoints for Products ---

// Get all products
app.get('/api/products', (req, res) => {
    const products = readData();
    res.json({ data: products }); 
});

// Get a single product
app.get('/api/products/:id', (req, res) => {
    const products = readData();
    const id = parseInt(req.params.id, 10);
    const product = products.find(p => p.id === id);
    if (product) {
        res.json(product);
    } else {
        res.status(404).json({ error: "Product not found" });
    }
});

// Create new product
app.post('/api/products', (req, res) => {
    const { sku, name, category, price, stock } = req.body;
    if (!sku || !name || !category || !price || !stock) {
        return res.status(400).json({ error: "Missing required fields" });
    }
    const products = readData();
    const newId = products.length > 0 ? Math.max(...products.map(p => p.id)) + 1 : 1;
    const newProduct = { id: newId, sku, name, category, price, stock };
    
    products.push(newProduct);
    writeData(products);
    
    res.status(201).json(newProduct);
});

// Update product
app.put('/api/products/:id', (req, res) => {
    const id = parseInt(req.params.id, 10);
    const { sku, name, category, price, stock } = req.body;
    
    const products = readData();
    const index = products.findIndex(p => p.id === id);
    
    if (index === -1) {
        return res.status(404).json({ error: "Product not found" });
    }
    
    products[index] = { ...products[index], sku, name, category, price, stock };
    writeData(products);
    
    res.json(products[index]);
});

// Delete product
app.delete('/api/products/:id', (req, res) => {
    const id = parseInt(req.params.id, 10);
    const products = readData();
    
    const filteredProducts = products.filter(p => p.id !== id);
    
    if (products.length === filteredProducts.length) {
        return res.status(404).json({ error: "Product not found" });
    }
    
    writeData(filteredProducts);
    res.json({ message: "Product deleted successfully" });
});

app.listen(PORT, () => {
    console.log(`Server is running at http://localhost:${PORT}`);
});
