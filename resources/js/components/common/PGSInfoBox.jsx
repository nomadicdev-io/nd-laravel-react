import { InfoBoxStyled } from "../../styles/common"
import { FaRegCircleCheck } from "react-icons/fa6";
import { RiErrorWarningLine } from "react-icons/ri";
import { RxCrossCircled } from "react-icons/rx";
import { FiInfo } from "react-icons/fi";

const PGSInfoBox = ({type, title, description}) => {
  return (
      <InfoBoxStyled type={type}>
        <div className="icon_">
          {
            type == 'success' ? <FaRegCircleCheck />
            : type == 'warning' ? <RiErrorWarningLine />
            : type == 'danger' ? <RxCrossCircled />
            : <FiInfo />
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