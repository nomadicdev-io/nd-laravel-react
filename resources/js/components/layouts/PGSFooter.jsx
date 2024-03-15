import React from 'react'
import { FooterStyled } from '../../styles/footer'
import PGSContainer from './PGSContainer'

const PGSFooter = () => {
  return (
    <FooterStyled>
        <PGSContainer>
            <p><span>PGS iO</span> - Developer Platform. © {new Date().getFullYear()} Planet Green Solutions. All Rights Reserved.</p>
        </PGSContainer>
    </FooterStyled>
  )
}

export default PGSFooter