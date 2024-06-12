// 별 js
document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');

    stars.forEach((star, idx) => {
        star.addEventListener('click', () => {
            stars.forEach((s, i) => {
                if (i <= idx) {
                    s.classList.add('checked');
                } else {
                    s.classList.remove('checked');
                }
            });
        });
    });
});


// 페이지네이션 js
document.addEventListener('DOMContentLoaded', () => {
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    const pageNumbersContainer = document.querySelector('.page-numbers');

    let currentPage = 1;
    const pagesPerGroup = 5;
    const totalPages = 100; // 예시로 총 100페이지로 설정

    function renderPageNumbers() {
        pageNumbersContainer.innerHTML = '';
        const startPage = Math.floor((currentPage - 1) / pagesPerGroup) * pagesPerGroup + 1;
        const endPage = Math.min(startPage + pagesPerGroup - 1, totalPages);

        for (let i = startPage; i <= endPage; i++) {
            const pageButton = document.createElement('button');
            pageButton.classList.add('page-number');
            if (i === currentPage) {
                pageButton.classList.add('active');
            }
            pageButton.textContent = i;
            pageButton.setAttribute('data-page', i);
            pageNumbersContainer.appendChild(pageButton);
        }

        prevButton.classList.toggle('disabled', currentPage === 1);
        nextButton.classList.toggle('disabled', currentPage === totalPages);
    }

    function updatePage(newPage) {
        if (newPage < 1 || newPage > totalPages) return;
        currentPage = newPage;
        renderPageNumbers();
    }

    pageNumbersContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('page-number')) {
            const selectedPage = parseInt(e.target.getAttribute('data-page'));
            updatePage(selectedPage);
        }
    });

    prevButton.addEventListener('click', () => {
        if (currentPage > 1) {
            updatePage(currentPage - 1);
        }
    });

    nextButton.addEventListener('click', () => {
        if (currentPage < totalPages) {
            updatePage(currentPage + 1);
        }
    });

    renderPageNumbers();
});



// 수량 증가 감소 체크 js
document.addEventListener('DOMContentLoaded', () => {
    const decreaseButton = document.getElementById('dec');
    const increaseButton = document.getElementById('inc');
    const quantityInput = document.getElementById('quantity');

    decreaseButton.addEventListener('click', () => {
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantity--;
            quantityInput.value = quantity;
        }
        toggleButtons();
    });

    increaseButton.addEventListener('click', () => {
        let quantity = parseInt(quantityInput.value);
        quantity++;
        quantityInput.value = quantity;
        toggleButtons();
    });

    quantityInput.addEventListener('input', () => {
        let quantity = parseInt(quantityInput.value);
        if (isNaN(quantity) || quantity < 1) {
            quantityInput.value = 1;
        }
        toggleButtons();
    });

    function toggleButtons() {
        decreaseButton.disabled = parseInt(quantityInput.value) === 1;
    }

    toggleButtons(); // 초기 상태 업데이트
});