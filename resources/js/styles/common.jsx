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