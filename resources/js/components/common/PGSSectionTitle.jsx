import React from 'react'
import { SectionTitleStyled } from '../../styles/common'

const PGSSectionTitle = ({children, title}) => {
  return (
    <SectionTitleStyled>
        <div className='title_'>
            <h2><span>{title}</span></h2>
        </div>
        {children}
    </SectionTitleStyled>
  )
}

export default PGSSectionTitle