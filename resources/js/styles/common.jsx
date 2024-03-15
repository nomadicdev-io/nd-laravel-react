import styled from 'styled-components';

export const MainStyled = styled.main`
    position: relative;
    min-width: 100%;
    max-width: 100%;
    min-height: 100vh;
`;

export const ContainerStyled = styled.div`
    position: relative;
    display: block;
    width: 100%;
    max-width: 96.5%;
    min-width: 96.5%;
    margin-inline: auto;
    padding-inline: 16px;

    @media only screen and (min-width: 767px) and (max-width: 1200px){
        min-width: 95%;
        max-width: 95%;
    }

    @media only screen and (min-width: 1200px){
        max-width: 92.5%;
        min-width: 92.5%;
    }

    @media only screen and (min-width: 1440px){
        max-width: 1360px;
        min-width: 1360px;
    }   
`;

export const SectionStyled = styled.div`
    position: relative;
    display: block;
    width: 100%;
    overflow: hidden;
    padding-block: 5rem;

    &.bg_grey{
        background-color: var(--bg-color-300);
    }

    &.padding_block_sm{
        padding-block: 2.5rem;
    }

`;

export const SectionTitleStyled = styled.div`
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;

    .title_{
        position: relative;
        display: block;

        h2{
            position: relative;
            display: block;
            margin: 0;
            padding: 0;
            font-size: 2.25rem;
            font-weight: bold;
        }
    }
`;

export const InfoBoxStyled = styled.div`
    position: relative;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    gap: 1rem;
    background-color: var(--bg-color);
    overflow: hidden;
    border-radius: 0.75rem;
    padding: 1rem;
    color: ${({type})=> type == 'success' ? 'var(--primary-color-600)' : type == 'warning' ? 'var(--yellow-color-600)' : type == 'danger' ? 'var(--red-color-600)' : 'var(--third-color-600)'};;

    &:before{
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: ${({type})=> type == 'success' ? 'var(--primary-color)' : type == 'warning' ? 'var(--yellow-color)' : type == 'danger' ? 'var(--red-color)' : 'var(--third-color)'};
        opacity: 0.1;
    }

    .icon_{
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 4rem;
        height: 4rem;
        border-radius: 0.6rem;
        overflow: hidden;
        font-size: 2rem;

        &:before{
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: ${({type})=> type == 'success' ? 'var(--primary-color)' : type == 'warning' ? 'var(--yellow-color)' : type == 'danger' ? 'var(--red-color)' : 'var(--third-color)'};
            opacity: 0.25;
        }

    }

    .content_{
        position: relative;
        display: block;
        flex: 1;
        h3, p{
            position: relative;
            display: block;
            margin: 0;
            padding: 0;
        }

        h3{
            font-size: 1rem;
            margin-bottom: 0.1em;
        }

        p{
            font-size: 0.8rem;
        }
    }
`;