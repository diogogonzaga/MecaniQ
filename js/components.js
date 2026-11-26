function carregarFooter() {

    const css = document.createElement('link');
    css.rel = 'stylesheet';
    css.href = '../css/footer.css';

    document.head.appendChild(css);

    fetch('../components/footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer').innerHTML = data;
        })
        .catch(error => console.error('Erro ao carregar footer:', error));
}

carregarFooter();






function carregarHeader() {

    const css = document.createElement('link');
    css.rel = 'stylesheet';
    css.href = '../css/header.css';

    document.head.appendChild(css);

    
    fetch('../components/header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header').innerHTML = data;
        })
        .catch(error => console.error('Erro ao carregar footer:', error));
}

carregarHeader();