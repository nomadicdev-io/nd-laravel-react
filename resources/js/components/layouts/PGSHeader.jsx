import { HeaderNavStyled, HeaderStyled, HeaderWrapperStyled } from "../../styles/header"
import PGSContainer from "./PGSContainer"

const PGSHeader = () => {
  return (
    <HeaderStyled>
        <PGSContainer>
            <HeaderWrapperStyled>
                <a href="/" className="nav_link">
                  <img src="/assets/frontend/dist/images/logo.svg" alt="PGSiO" />
                </a>

                <HeaderNavStyled>
                  <ul>
                    <li>
                      <a href="/"><span>Home</span></a>
                      </li>
                      <li>
                      <a href="/"><span>Guideline</span></a>
                      </li>
                      <li>
                      <a href="/"><span>Team</span></a>
                      </li>
                      <li>
                      <a href="/"><span>Gallery</span></a>
                      </li>
                      <li>
                      <a href="/"><span>Works</span></a>
                    </li>
                  </ul>
                </HeaderNavStyled>
            </HeaderWrapperStyled>
        </PGSContainer>
    </HeaderStyled>
  )
}

export default PGSHeader