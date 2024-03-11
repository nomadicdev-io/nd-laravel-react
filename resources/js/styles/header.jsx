import styled from 'styled-components';

export const HeaderStyled = styled.header`
    position: relative;
    display: block;
    width: 100%;
    height: auto;
`;

export const HeaderWrapperStyled = styled.div`
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding-block: 1.5rem;

    .nav_link{
        position: relative;
        display: inline-block;
        width: auto;
        height: 100%;
        height: 2rem;

        img{
            width: auto;
            height: 100%;
        }
    }

`;

export const HeaderNavStyled = styled.nav`
    position: relative;
    display: block;
    width: auto;

    ul{
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 1.25rem;

        li{
            position: relative;
            display: block;

            a{
                position: relative;
                display: inline-block;
                color: var(--text-color);
                font-size: 0.9rem;
                font-weight: 600;
            }
        }
    }

`;