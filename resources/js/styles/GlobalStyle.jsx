import { createGlobalStyle } from 'styled-components';

const GlobalStyle = createGlobalStyle`

    :root {
        --font-family: 'Poppins', san-serif;
        --primary-color: #36c670;
        --primary-color-600: #268b65;
        --secondary-color: #75b9be;
        --secondary-color-600: #588b8f;
        --third-color: #90baad;
        --third-color-600: #6c8b82;
        --text-color: #444444;
        --text-color-600: #101010;
        --bg-color: #FFF;
        --bg-color-300: #fafafa;
        --white-color: #FFF;
        --border-color: #eaf1ef;
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
        font-weight: bold;
    }

    .info_grid{
        position: relative;
        display: grid;
        grid-template-columns: 1fr 1fr;

        .full_{
            grid-column: 1/-1
        }
    }

    .info_bar {
        position: relative;
        display: block;
        width: 100%;
        border-bottom: 1px solid var(--border-color);
        padding-block: 1.5rem;

 
        h4 {
            position: relative;
            display: block;
            margin: 0;
            font-weight: 600;
            font-size: 1.35rem;
            margin-bottom: 0.5em;
            color: var(--primary-color-600);
        }
    }

`;

export default GlobalStyle;