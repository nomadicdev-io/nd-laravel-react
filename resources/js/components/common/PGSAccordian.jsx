import {useState} from 'react'
import { AccordianGridStyled, AccordianStyled } from '../../styles/common'
import { FaCircleChevronDown } from "react-icons/fa6"
import { motion } from 'framer-motion';

const PGSAccordian = ({data}) => {

    const [isOpen, setIsOpen] = useState(data.map(()=> {return false}))

    const openTab = (value)=> {
        setIsOpen(isOpen.map((el, index)=> {
            if(index == value){
                return !el
            }else{
                return false
            }
        }))
    }

  return (
    <AccordianGridStyled>
        {
            data &&

            data.map((item, index)=> (
                <AccordianStyled layout="position" key={'pgs-accordian-' + index} className={isOpen[index] ? 'active_' : null}>
                    <div className='accordian_header' onClick={()=> openTab(index)}>
                        <h4>{item.title}</h4>
                        <div className='accordian_toggle'>
                            <FaCircleChevronDown />
                        </div>
                    </div>
                    {
                        isOpen[index] &&
                        <motion.div 
                        initial={{ opacity: 0, y: 50 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{
                            delay: 0.2,
                        }}
                        className='accordian_body'>
                            <p>{item.description}</p>
                        </motion.div>
                    }
                </AccordianStyled>
            ))
        }
    </AccordianGridStyled>
  )
}

export default PGSAccordian