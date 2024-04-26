import {useEffect} from 'react'
import PGSRoutes from "./PGSRoutes"
import PGSFooter from "./components/layouts/PGSFooter"
import PGSHeader from "./components/layouts/PGSHeader"
import PGSMain from "./components/layouts/PGSMain"
import GlobalStyle from "./styles/GlobalStyle"
import { BrowserRouter } from 'react-router-dom'
import { useTranslation } from 'react-i18next';
import { atom, useAtom } from 'jotai'

export const LANG = atom('')

const App = () => {

  const { i18n } = useTranslation();
  const [lang, setLang] = useAtom(LANG)

  useEffect(()=> {
    setLang(i18n.language)
  }, [])

  return (
    <BrowserRouter basename={import.meta.env.VITE_PUBLIC_APP_BASE_URL + '/' + i18n.language}>
      <GlobalStyle />
      <PGSHeader />
      <PGSMain>
        <PGSRoutes />
      </PGSMain>
      <PGSFooter />
    </BrowserRouter>
  )
}

export default App