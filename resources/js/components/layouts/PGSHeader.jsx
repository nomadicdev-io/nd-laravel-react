import { HeaderNavStyled, HeaderStyled, HeaderWrapperStyled } from "../../styles/header"
import { PGSButton } from "../common/PGSButtons"
import PGSContainer from "./PGSContainer"
import { IoGlobeOutline } from "react-icons/io5";

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
                      <a href="/" className="active_"><span>Home</span></a>
                      </li>
                      <li>
                      <a href="/"><span>UI Components</span></a>
                      </li>
                      <li>
                      <a href="/"><span>Team</span></a>
                      </li>
                      <li>
                      <a href="/"><span>Gallery</span></a>
                      </li>
                      <li>
                      <a href="/"><span>Projects</span></a>
                      </li>
                    </ul>
                </HeaderNavStyled>

                <PGSButton title={'Arabic'} icon={<IoGlobeOutline />} type={'button'} className={'primary_'}/>

            </HeaderWrapperStyled>
        </PGSContainer>
    </HeaderStyled>
  )
}

export default PGSHeader