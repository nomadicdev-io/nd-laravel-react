import React from 'react'
import { BadgesStyled } from '../../styles/common'

const PGSBadge = ({title, className, number}) => {
  return (
    <BadgesStyled className={className}>
      <span>{title}</span>
      {
        number &&
        <div className='number_'>{number}</div>
      }
    </BadgesStyled>
  )
}

export default PGSBadge