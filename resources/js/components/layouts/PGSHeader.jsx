import { Link, NavLink } from "react-router-dom";
import { HeaderNavStyled, HeaderStyled, HeaderWrapperStyled } from "../../styles/header"
import { PGSButton } from "../common/PGSButtons"
import PGSContainer from "./PGSContainer"
import { IoGlobeOutline } from "react-icons/io5";
import logoImage from '$/assets/logo.svg'
import { useTranslation } from 'react-i18next';

const PGSHeader = () => {

  const { i18n } = useTranslation();

  return (
    <HeaderStyled>
        <PGSContainer>
            <HeaderWrapperStyled>
            
                <Link href="/" className="nav_link">
                  <img src={logoImage} alt="PGSiO" />
                </Link>

                <HeaderNavStyled>
                    <ul>
                      <li>
                      <NavLink to="/" className={({ isActive }) => (isActive ? 'active_' : '')}><span>Home</span></NavLink>
                      </li>
                      <li>
                      <NavLink to="/ui-components" className={({ isActive }) => (isActive ? 'active_' : '')}><span>UI Components</span></NavLink>
                      </li>
                      <li>
                      <NavLink to="/layouts" className={({ isActive }) => (isActive ? 'active_' : '')}><span>Layouts</span></NavLink>
                      </li>
                      <li>
                      <NavLink to="/team" className={({ isActive }) => (isActive ? 'active_' : '')}><span>Team</span></NavLink>
                      </li>
                      <li>
                      <NavLink to="/gallery" className={({ isActive }) => (isActive ? 'active_' : '')}><span>Gallery</span></NavLink>
                      </li>
                      <li>
                      <NavLink to="/projects" className={({ isActive }) => (isActive ? 'active_' : '')}><span>Projects</span></NavLink>
                      </li>
                    </ul>
                </HeaderNavStyled>

                <PGSButton title={i18n.language == 'en' ? 'عربي' : 'English'} icon={<IoGlobeOutline />} type={'button'} onClick={()=> i18n.changeLanguage(i18n.language == 'en' ? 'ar' : 'en')}/>

            </HeaderWrapperStyled>
        </PGSContainer>
    </HeaderStyled>
  )
}

export default PGSHeader