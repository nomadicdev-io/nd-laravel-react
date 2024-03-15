import styled from 'styled-components';
import { motion } from 'framer-motion';

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
    color: ${({type})=> type == 'success' ? 'var(--primary-color-600)' : type == 'warning' ? 'var(--yellow-color-600)' : type == 'danger' ? 'var(--red-color-600)' : 'var(--third-color-600)'};
    box-shadow: inset 0px 0px 0px 1px ${({type})=> type == 'success' ? 'var(--primary-color)' : type == 'warning' ? 'var(--yellow-color)' : type == 'danger' ? 'var(--red-color)' : 'var(--third-color)'};
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
        color: ${({type})=> type == 'success' ? 'var(--primary-color)' : type == 'warning' ? 'var(--yellow-color)' : type == 'danger' ? 'var(--red-color)' : 'var(--third-color)'};

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

export const AccordianGridStyled = styled.div`
    position: relative;
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    width: 100%;
`;

export const AccordianStyled = styled(motion.div)`
    position: relative;
    display: block;
    width: 100%;
    height: auto;
    background-color: var(--bg-color);
    box-shadow: 0px 3px 12px 0px #00000017;
    border-radius: 0.75rem;
    overflow: hidden;

    .accordian_header {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        padding: 1.25rem 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;

        &:hover{
            background-color: var(--bg-color-300);
        }

        h4{
            position: relative;
            display: block;
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .accordian_toggle {
            position: relative;
            display: inline-flex;
            font-size: 1.5rem;
            transform-origin: center;
            transition: all 0.3s ease;
        }
    }

    .accordian_body{
        position: relative;
        display: block;
        width: 100%;
        padding: 1.5rem;

        p{
            position: relative;
            display: block;
            margin: 0;
            font-size: 1.1rem;
        }
    }

    &.active_{
        .accordian_header {
            background-color: var(--bg-color-300);

            .accordian_toggle{
                transform: rotate(-180deg);
                color: var(--primary-color);
            }
        }
    }
`;

export const BadgesStyled = styled.div`
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: flex-start;
    gap: 1em;
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.35em 1em;
    border-radius: 0.5em;
    background-color: var(--text-color);
    color: var(--white-color);

    span{
        display: inline-block;
    }

    .number_{
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5em;
        height: 2.5em;
        border-radius: 50%;
        overflow: hidden;
        font-size: 0.8em;
        margin-block: 0.5em;

        &:before{
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--white-color);
            opacity: 0.2;
        }
    }

    &.md_{font-size: 0.85rem}
    &.lg_{font-size: 0.95rem}

    &.primary_{background-color: var(--primary-color)}
    &.secondary_{background-color: var(--secondary-color)}
    &.third_{background-color: var(--third-color)}
    &.success_{background-color: var(--green-color)}
    &.warning_{background-color: var(--yellow-color)}
    &.danger_{background-color: var(--red-color)}
`;