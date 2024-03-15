import { InfoBoxStyled } from "../../styles/common"
import {     
  FaCircleCheck,
  FaCircleXmark,
  FaCircleExclamation,
  FaCircleInfo } from "react-icons/fa6";

const PGSInfoBox = ({type, title, description}) => {
  return (
      <InfoBoxStyled type={type}>
        <div className="icon_">
          {
            type == 'success' ? <FaCircleCheck />
            : type == 'warning' ? <FaCircleExclamation />
            : type == 'danger' ? <FaCircleXmark />
            : <FaCircleInfo />
          }
        </div>
        <div className="content_">
          {
            title && <h3>{title}</h3>
          }
          {
            description && <p>{description}</p>
          }
        </div>
      </InfoBoxStyled>
  )
}

export default PGSInfoBox