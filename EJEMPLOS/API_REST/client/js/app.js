const API_URL = 'http://localhost/UTP/repositorio/EJEMPLOS/API_REST/api'; // Adjust this to your API's URL
const API_KEY = 'testapikey123'; // This should be securely stored and retrieved
let JWT_TOKEN = localStorage.getItem('jwt_token');

async function login(email, password) {
    try {
        const response = await fetch(`${API_URL}/login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        const data = await response.json();
        if (typeof data.token !== 'string' || data.token.trim() === '') {
            throw new Error('Invalid token in response');
        }
        JWT_TOKEN = data.token;
        localStorage.setItem('jwt_token', JWT_TOKEN);
        console.log('Login successful. JWT Token:', JWT_TOKEN);
        return true;
    } catch (error) {
        console.error('Login error:', error);
        return false;
    }
}

async function fetchFromAPI(endpoint, method = 'GET', useJWT = false, body = null) {
    try {
        let headers = useJWT
            ? { 'Authorization': `Bearer ${JWT_TOKEN}`, 'Content-Type': 'application/json' }
            : { 'X-API-Key': API_KEY, 'Content-Type': 'application/json' };
        
        const options = {
            method,
            headers,
            body: body ? JSON.stringify(body) : null
        };

        const response = await fetch(`${API_URL}/${endpoint}`, options);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error('Fetch error:', error);
        displayError(`Failed to fetch data from the API: ${error.message}`);
    }
}

function displayProducts(products) {
    const content = document.getElementById('content');
    let html = `
        <h2>Products</h2>
        <button onclick="showCreateProductForm()">Create New Product</button>
        <table>
            <tr><th>ID</th><th>Name</th><th>Price</th></tr>
            ${products.map(product => `
                <tr>
                    <td>${product.id}</td>
                    <td>${product.name}</td>
                    <td>$${product.price}</td>
                </tr>
            `).join('')}
        </table>
    `;
    content.innerHTML = html;
}

function displayUsers(users) {
    const content = document.getElementById('content');
    let html = `
        <h2>Users</h2>
        <button onclick="showCreateUserForm()">Create New User</button>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th></tr>
            ${users.map(user => `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                </tr>
            `).join('')}
        </table>
    `;
    content.innerHTML = html;
}

function showCreateProductForm() {
    const content = document.getElementById('content');
    content.innerHTML = `
        <h2>Create New Product</h2>
        <form id="createProductForm">
            <input type="text" id="productName" placeholder="Product Name" required>
            <input type="number" id="productPrice" placeholder="Price" step="0.01" required>
            <button type="submit">Create Product</button>
        </form>
    `;
    document.getElementById('createProductForm').addEventListener('submit', createProduct);
}

function showCreateUserForm() {
    const content = document.getElementById('content');
    content.innerHTML = `
        <h2>Create New User</h2>
        <form id="createUserForm">
            <input type="text" id="userName" placeholder="Name" required>
            <input type="email" id="userEmail" placeholder="Email" required>
            <input type="password" id="userPassword" placeholder="Password" required>
            <button type="submit">Create User</button>
        </form>
    `;
    document.getElementById('createUserForm').addEventListener('submit', createUser);
}

async function createProduct(event) {
    event.preventDefault();
    const name = document.getElementById('productName').value;
    const price = document.getElementById('productPrice').value;
    const result = await fetchFromAPI('products', 'POST', true, { name, price });
    if (result) {
        alert('Product created successfully');
        loadProducts();
    }
}

async function createUser(event) {
    event.preventDefault();
    const name = document.getElementById('userName').value;
    const email = document.getElementById('userEmail').value;
    const password = document.getElementById('userPassword').value;
    const result = await fetchFromAPI('users', 'POST', false, { name, email, password });
    if (result) {
        alert('User created successfully');
        loadUsers();
    }
}

function displayError(message) {
    const content = document.getElementById('content');
    content.innerHTML = `<div class="error">${message}</div>`;
}

async function loadProducts() {
    if (!JWT_TOKEN) {
        const email = prompt("Enter your email:");
        const password = prompt("Enter your password:");
        if (await login(email, password)) {
            const products = await fetchFromAPI('products', 'GET', true);
            if (products) displayProducts(products);
        } else {
            displayError('Login failed. Unable to fetch products.');
        }
    } else {
        const products = await fetchFromAPI('products', 'GET', true);
        if (products) displayProducts(products);
    }
    setActiveNavItem('showProducts');
}

async function loadUsers() {
    const users = await fetchFromAPI('users');
    if (users) displayUsers(users);
    setActiveNavItem('showUsers');
}

function setActiveNavItem(id) {
    document.querySelectorAll('nav button').forEach(btn => btn.classList.remove('active'));
    document.getElementById(id).classList.add('active');
}

document.getElementById('showProducts').addEventListener('click', loadProducts);
document.getElementById('showUsers').addEventListener('click', loadUsers);

// Initial load: show users
document.addEventListener('DOMContentLoaded', loadUsers);