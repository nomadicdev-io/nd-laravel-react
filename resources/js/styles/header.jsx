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
    padding-block: 2rem;

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
        gap:0.75rem;

        li{
            position: relative;
            display: block;

            a{
                position: relative;
                display: inline-block;
                color: var(--text-color);
                font-size: 0.85rem;
                font-weight: 500;
                overflow: hidden;
                padding: 0.35rem 1rem;
                border-radius: 0.5rem;

                &:before{
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: var(--primary-color);
                    opacity: 0;
                }

                &.active_{
                    color: var(--primary-color-600);
                    
                    &:before{
                        opacity: 0.1;
                    }
                }
            }
        }
    }

`;