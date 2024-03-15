import React from 'react'
import { SectionStyled } from '../../styles/common'

const PGSSection = ({children, className}) => {
  return (
    <SectionStyled className={className}>
        {children}
    </SectionStyled>
  )
}

export default PGSSection