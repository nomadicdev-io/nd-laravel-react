import { HeaderStyled, HeaderWrapperStyled } from "../../styles/header"
import PGSContainer from "./PGSContainer"

const PGSHeader = () => {
  return (
    <HeaderStyled>
        <PGSContainer>
            <HeaderWrapperStyled>
                <h2>PGS Laravel-React V1.0</h2>
            </HeaderWrapperStyled>
        </PGSContainer>
    </HeaderStyled>
  )
}

export default PGSHeader