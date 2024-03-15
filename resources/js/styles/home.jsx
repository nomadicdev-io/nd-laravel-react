import styled from 'styled-components';

export const HomeBannerStyled = styled.div`
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: auto;
    overflow: hidden;
    gap: 7.5vw;
    padding-block: 5rem;
    border-bottom: 2px solid var(--border-color);
    
    .title_{
        position: relative;
        display: block;
        width: 50%;
        h2{
            position: relative;
            display: block;
            margin: 0;
            padding: 0;
            font-size: 2.75rem;
            font-weight: 500;
            line-height: 1.25;
  

            strong{
                color: var(--primary-color);
                font-weight: bold;
            }

            span{
                color: var(--secondary-color-600);
                font-weight: bold;
            }
            
        }

        p{
            position: relative;
            display: block;
            margin: 0 auto;
            font-size: 1.1rem;
            margin-top: 0.5em;
            max-width: 100%;
        }
    }

    .banner_widget{
        position: relative;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        width: 100%;
        margin-inline: auto;
        flex: 1;

        .item_{
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            border-radius: 1.5rem;
            overflow: hidden;
            background-color: var(--primary-color);
            aspect-ratio: 1/1;

            &:nth-child(2){background-color: var(--secondary-color)}
            &:nth-child(3){background-color: var(--third-color)}

            svg {
                position: relative;
                display: block;
                max-width: 55%;
                opacity: 0.6;
                max-height: 45%;
            }


        }
        
    }
`; 