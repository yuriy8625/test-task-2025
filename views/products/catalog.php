<div class="container">

    <div class="filter">
        <div class="filter--sort">
            <label for="sortSelect">Сортування:</label>
            <select id="sortSelect" name="order">
                <option value="title-asc">За назвою А-Я</option>
                <option value="title-desc">За назвою Я-А</option>
                <option value="price-asc">Від дешевих до дорогих</option>
                <option value="price-desc">Від дорогих дошевих</option>

            </select>
        </div>
    </div>

    <div class="products"></div>

    <div class="pagination"></div>
</div>

<script>
    let currentPage = 1;
    let itemsPerPage = 10;
    let totalItems = 0;

    const SORT_FIELDS = ['price', 'title'];
    const DEFAULT_SORT_FIELD = 'title';
    const DEFAULT_SORT_DIRECTION = 'asc';

    function getParamsFromURL() {
        const params = new URLSearchParams(window.location.search);

        const page = parseInt(params.get("page")) || 1;
        const limit = parseInt(params.get("limit")) || itemsPerPage;

        const sortParam = params.get("sort") || DEFAULT_SORT_FIELD;
        const dirParam = params.get("direction") || DEFAULT_SORT_DIRECTION;

        currentPage = page;
        itemsPerPage = limit;

        const sortSelect = document.getElementById("sortSelect");
        sortSelect.value = `${sortParam}-${dirParam}`;

        return { sortField: sortParam, sortDirection: dirParam };
    }

    function updateURL(sortField, sortDirection) {
        const params = new URLSearchParams(window.location.search);
        params.set("page", currentPage);
        params.set("limit", itemsPerPage);
        params.set("sort", sortField);
        params.set("direction", sortDirection);
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.history.replaceState({}, "", newUrl);
    }

    function parseSort() {
        const sortSelect = document.getElementById("sortSelect");
        const [field, dir] = sortSelect.value ? sortSelect.value.split("-") : [];
        const sortField = SORT_FIELDS.includes(field) ? field : DEFAULT_SORT_FIELD;
        const sortDirection = dir === "desc" ? "desc" : DEFAULT_SORT_DIRECTION;
        return { sortField, sortDirection };
    }

    async function fetchProducts() {
        try {
            const { sortField, sortDirection } = parseSort();

            updateURL(sortField, sortDirection);

            const response = await fetch(
                `/api/products?sort=${sortField}&direction=${sortDirection}&page=${currentPage}&limit=${itemsPerPage}`
            );

            const data = await response.json();

            const products = data.items;
            totalItems = data.total;
            itemsPerPage = data.limit;

            renderProducts(products);
        } catch (err) {
            console.error(err);
        }
    }

    function renderProducts(products) {
        const productsContainer = document.querySelector(".products");

        if (!products || !products.length) {
            productsContainer.innerHTML = "<p>Продуктів не знайдено</p>";
            document.querySelector(".pagination").innerHTML = "";
            return;
        }

        productsContainer.innerHTML = products.map(p => `
                <div class="product">
                    <h3 class="product--title">${p.title}</h3>
                    <p class="product--price">Ціна: ${p.price} грн</p>
                </div>
            `).join("");

        renderPagination();
    }

    function renderPagination() {
        const paginationContainer = document.querySelector(".pagination");
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        if (totalPages <= 1) {
            paginationContainer.innerHTML = "";
            return;
        }

        const buttons = [];

        if (currentPage > 1) buttons.push(`<button class="pagination-btn" data-page="${currentPage - 1}">Назад</button>`);

        for (let i = 1; i <= totalPages; i++) {
            buttons.push(`<button class="pagination-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
        }

        if (currentPage < totalPages) buttons.push(`<button class="pagination-btn" data-page="${currentPage + 1}">Вперед</button>`);

        paginationContainer.innerHTML = buttons.join("");

        paginationContainer.querySelectorAll(".pagination-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                currentPage = parseInt(btn.dataset.page);
                fetchProducts();
            });
        });
    }

    document.getElementById("sortSelect").addEventListener("change", () => {
        currentPage = 1;
        fetchProducts();
    });

    document.addEventListener("DOMContentLoaded", () => {
        parseSort();
        const params = new URLSearchParams(window.location.search);
        currentPage = parseInt(params.get("page")) || 1;
        itemsPerPage = parseInt(params.get("limit")) || itemsPerPage;

        fetchProducts();
    });
</script>
