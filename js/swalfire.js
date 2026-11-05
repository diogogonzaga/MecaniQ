// Script para os alertas bonitos 

function account(event) {
    event.preventDefault();

    Swal.fire({
        title: "Área exclusiva para oficinas",
html: "Esta página é apenas para oficinas.<br>Deseja prosseguir?",
         icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, entrar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "account/login/index.html";
        }
    });
}




function Termos() {
    Swal.fire({
        title: 'Termos e Condições de Uso - MecaniQ',
        html: `
            <div style="text-align:left; max-height:300px; overflow-y:auto; font-size:14px; padding-right: 5px;">
<p><strong>Última atualização:</strong> 5 de novembro de 2026</p>
                <p>Bem-vindo(a) á <strong>MecaniQ</strong>, uma plataforma web destinada a proprietários de veículos que necessitam de encontrar oficinas de forma rápida e simples.</p>

                <h4>1. Definições</h4>
                <p><strong>Plataforma:</strong> Aplicação e serviços web do MecaniQ.<br>
                <strong>Utilizador:</strong> Proprietário de veículo ou representante que utilize a plataforma.<br>
                <strong>Oficina:</strong> Prestador de serviços mecânicos registado ou listado na plataforma.</p>

                <h4>2. Uso da Plataforma</h4>
                <ul>
                    <li>Utilização lícita para pesquisa, comparação e marcação de serviços;</li>
                    <li>Compromisso de veracidade nas informações fornecidas para marcações;</li>
                    <li>Proibição de utilização abusiva, fraudulenta ou spam na plataforma.</li>
                </ul>

                <h4>3. Marcações e Preços</h4>
                <p>O MecaniQ facilita a comparação de serviços e preços entre diferentes oficinas. Os valores e a disponibilidade apresentados são indicativos e da responsabilidade final dos prestadores de serviços.</p>

                <h4>4. Responsabilidade</h4>
                <p>A plataforma atua como intermediária na simplificação do processo de contacto e marcação, sendo fornecida “tal como está”, sem garantias absolutas sobre os serviços prestados pelas oficinas parceiras.</p>

                <p><em>Este documento destina-se a fins demonstrativos e ilustrativos da plataforma MecaniQ.</em></p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Fechar',
        confirmButtonColor: '#2563eb', // Tom azul moderno
        width: 700

    });
}

function Privacidade() {
    Swal.fire({
        title: 'Política de Privacidade - MecaniQ',
        html: `
            <div style="text-align:left; max-height:300px; overflow-y:auto; font-size:14px; padding-right: 5px;">
                <p><strong>Última atualização:</strong> 5 de novembro de 2026</p>

                <p>A presente Política de Privacidade descreve como a <strong>MecaniQ</strong> recolhe, utiliza e protege os dados dos utilizadores e proprietários de veículos na plataforma.</p>

                <h4>1. Dados Recolhidos</h4>
                <ul>
                    <li>Dados de identificação e contacto (nome, email, telefone);</li>
                    <li>Informações técnicas sobre os veículos associados às marcações;</li>
                    <li>Dados de utilização e preferências de pesquisa de oficinas.</li>
                </ul>

                <h4>2. Finalidade do Tratamento</h4>
                <p>Os dados recolhidos são utilizados para:</p>
                <ul>
                    <li>Possibilitar a pesquisa e marcação de serviços nas oficinas;</li>
                    <li>Facilitar a comunicação entre o utilizador e a oficina escolhida;</li>
                    <li>Melhorar o funcionamento, transparência e experiência na plataforma.</li>
                </ul>

                <h4>3. Partilha de Dados</h4>
                <p>Os dados necessários para a marcação (como contacto e detalhes do veículo) são partilhados exclusivamente com a oficina selecionada pelo utilizador para a execução do serviço pretendido.</p>

                <h4>4. Segurança</h4>
                <p>São aplicadas medidas técnicas e organizativas adequadas para proteger os dados pessoais contra acessos não autorizados.</p>

                <h4>5. Direitos do Utilizador</h4>
                <p>O utilizador pode solicitar a qualquer momento o acesso, correção ou eliminação dos seus dados pessoais armazenados na plataforma.</p>

                <p><em>Esta política respeita o enquadramento demonstrativo e educacional da aplicação MecaniQ.</em></p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Fechar',
        confirmButtonColor: '#2563eb', // Tom azul moderno
        width: 700
    })
}



