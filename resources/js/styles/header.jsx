import styled from 'styled-components';

export const HeaderStyled = styled.header`
    position: relative;
    display: block;
    width: 100%;
    height: auto;
    background-color: var(--primary-color);
    color: var(--white-color);
`;

export const HeaderWrapperStyled = styled.div`
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 4.5rem;

    h2{
        position: relative;
        display: block;
        margin: 0;
        font-size: 1.25rem;
    }

`;

export const HeaderNavStyles = styled.nav`
    position: relative;
    display: block;
    width: auto;

    ul{
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-start;

        li{
            position: relative;
            display: block;
        }
    }

`;