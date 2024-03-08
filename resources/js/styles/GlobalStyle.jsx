import { createGlobalStyle } from 'styled-components';

const GlobalStyle = createGlobalStyle`

    :root {
        --font-family: 'Inter', san-serif;
        --primary-color: #7678ed;
        --secondary-color: #65afff;
        --text-color: #253031;
        --bg-color: #FFF;
        --white-color: #FFF;
        --border-color: #e1e1e1;
        --green-color: #15d060;
        --yellow-color: #fecb34;
        --red-color: #ff4639;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: var(--border-color);
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--text-color);
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-color);
    }

    html {
        box-sizing: border-box;
        font-family: var(--font-family);
        font-size: 17px;
    
        @media only screen and (max-width: 1360px){
            font-size: 16px;
        }
    
        @media only screen and (max-width: 767px){
            font-size: 14px;
        }
    }

    *,
    *:before,
    *:after {
        box-sizing: border-box;
    }

    body {
        position: relative;
        color: var(--text-color);
        font-weight: normal;
        line-height: 1.75;
        padding: 0;
        margin: 0;
        background-color: var(--bg-color);
        text-rendering: optimizeLegibility;
        -webkit-text-size-adjust: 100%;
        -moz-text-size-adjust: 100%;
        text-size-adjust: 100%;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        max-width: 100%;
        font-weight: normal;
    }
    
    ul,ol{
        padding: 0;
        margin: 0;
    }
    
    a{
        color: var(--text-color);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    h1,h2,h3,h4,h5{
        font-weight: 600;
    }

`;

export default GlobalStyle;