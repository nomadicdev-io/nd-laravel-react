import styled from 'styled-components';

export const ButtonGroupStyled = styled.div`
    position: relative;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 0.5rem;
    flex-wrap: wrap;

    &.end_{
        justify-content: flex-end;
    }

    &.between{
        justify-content: space-between;
    }

    &.center_{
        justify-content: center;
    }

`;

export const ButtonStyled = styled.button`
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: flex-start;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--white-color);
    border: none;
    outline: none;
    background-color: var(--text-color);
    cursor: pointer;
    height: 2.75rem;
    border-radius: 0.6rem;
    transition: all 0.3s ease;
    padding: 0;
    
    span{
        display: inline-block;
        padding-inline: 1rem;
    }

    .icon_{
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.6rem;
        overflow: hidden;
        font-size: 1.35em;
        transform: scale(0.8);
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

        svg{
            position: relative;
        }
    }

    &:hover{
        background-color: var(--text-color-600);
        box-shadow: 0px 1px 10px 0px var(--text-color);
    }

    &.outline_{
        background-color: transparent;
        box-shadow: 0px 0px 0px 1px var(--text-color);
        color: var(--text-color);

        .icon_{
            &:before{
                opacity: 0.1;
                background-color: var(--text-color);
            }
        }

        &:hover{
            color: var(--white-color);
            background-color: var(--text-color-600);
            box-shadow: 0px 0px 0px 1px var(--text-color-600);
            
            .icon_{
                &::before{
                    opacity: 0.2;
                    background-color: var(--white-color) !important;
                }
            }
        }

        
    }

    &.primary_{
        background-color: var(--primary-color);

        &:hover{
            background-color: var(--primary-color-600);
            box-shadow: 0px 1px 10px 0px var(--primary-color-600);
        }

        &.outline_{
            background-color: transparent;
            box-shadow: 0px 0px 0px 1px var(--primary-color);
            color: var(--primary-color);

            .icon_{
                &:before{
                    background-color: var(--primary-color);
                }
            }

            &:hover{
                color: var(--white-color);
                background-color: var(--primary-color);
            }
        }
    }

    &.secondary_{
        background-color: var(--secondary-color);

        &:hover{
            background-color: var(--secondary-color-600);
            box-shadow: 0px 1px 10px 0px var(--secondary-color-600);
        }

        &.outline_{
            background-color: transparent;
            box-shadow: 0px 0px 0px 1px var(--secondary-color);
            color: var(--secondary-color);

           .icon_{
                &:before{
                    background-color: var(--secondary-color);
                }
           }

            &:hover{
                color: var(--white-color);
                background-color: var(--secondary-color);
            }
        }
    }

    &.third_{
        background-color: var(--third-color);

        &:hover{
            background-color: var(--third-color-600);
            box-shadow: 0px 1px 10px 0px var(--third-color-600);
        }

        &.outline_{
            background-color: transparent;
            box-shadow: 0px 0px 0px 1px var(--third-color-600);
            color: var(--third-color-600);

            .icon_{
                &:before{
                    background-color: var(--third-color-600);
                }
            }

            &:hover{
                color: var(--white-color);
                background-color: var(--third-color-600);
            }
        }
    }
`;

export const IconButtonStyled = styled.button`
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: var(--white-color);
    border: none;
    outline: none;
    background-color: var(--text-color);
    cursor: pointer;
    height: 2.75rem;
    width: 2.75rem;
    border-radius: 0.6rem;
    transition: all 0.3s ease;
    padding: 0;

    &:hover{
        background-color: var(--text-color-600);
        box-shadow: 0px 1px 10px 0px var(--text-color);
    }

    &.outline_{
        background-color: transparent;
        box-shadow: 0px 0px 0px 1px var(--text-color);
        color: var(--text-color);

        &:hover{
            color: var(--white-color);
            background-color: var(--text-color-600);
            box-shadow: 0px 0px 0px 1px var(--text-color-600);
            
            .icon_{
                &::before{
                    opacity: 0.2;
                    background-color: var(--white-color) !important;
                }
            }
        }

        
    }
    
    &.primary_{
        background-color: var(--primary-color);

        &:hover{
            background-color: var(--primary-color-600);
            box-shadow: 0px 1px 10px 0px var(--primary-color);
        }

        &.outline_{
            background-color: transparent;
            box-shadow: 0px 0px 0px 1px var(--primary-color);
            color: var(--primary-color);

            &:hover{
                color: var(--white-color);
                background-color: var(--primary-color);
            }
        }
    }

    &.secondary_{
        background-color: var(--secondary-color);

        &:hover{
            background-color: var(--secondary-color-600);
            box-shadow: 0px 1px 10px 0px var(--secondary-color);
        }

        &.outline_{
            background-color: transparent;
            box-shadow: 0px 0px 0px 1px var(--secondary-color);
            color: var(--secondary-color);

            &:hover{
                color: var(--white-color);
                background-color: var(--secondary-color);
            }
        }
    }

    &.third_{
        background-color: var(--third-color);

        &:hover{
            background-color: var(--third-color-600);
            box-shadow: 0px 1px 10px 0px var(--third-color);
        }

        &.outline_{
            background-color: transparent;
            box-shadow: 0px 0px 0px 1px var(--third-color-600);
            color: var(--third-color-600);

            &:hover{
                color: var(--white-color);
                background-color: var(--third-color-600);
            }
        }
    }
`;