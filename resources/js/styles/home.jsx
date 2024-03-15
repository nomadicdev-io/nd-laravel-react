import styled from 'styled-components';

export const HomeBannerStyled = styled.div`
    position: relative;
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    height: auto;
    overflow: hidden;
    padding-top: 2.5rem;

    .title_{
        position: relative;
        display: block;
        width: 100%;
        h2{
            position: relative;
            display: block;
            margin: 0 0 0.5em;
            padding: 0;
            font-size: 4rem;
            font-weight: normal;
            line-height: 1.5;
            max-width: 90%;

            span{
                color: var(--primary-color);
            }
            
        }

        p{
            position: relative;
            display: block;
            font-size: 1.5rem;
            margin-top: 0.5em;
            max-width: 100%;
            max-width: 85%;
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
        margin-top: 2.5rem;

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