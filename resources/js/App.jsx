import PGSRoutes from "./PGSRoutes"
import PGSFooter from "./components/layouts/PGSFooter"
import PGSHeader from "./components/layouts/PGSHeader"
import PGSMain from "./components/layouts/PGSMain"
import Home from "./routes/home"
import GlobalStyle from "./styles/GlobalStyle"

const App = () => {

  console.log(import.meta.env.VITE_PUBLIC_APP_BASE_URL)

  return (
    <>
      <GlobalStyle />
      <PGSHeader />
      <PGSMain>
        <PGSRoutes />
      </PGSMain>
      <PGSFooter />
    </>
    
  )
}

export default App