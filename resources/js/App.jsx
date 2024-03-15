import PGSFooter from "./components/layouts/PGSFooter"
import PGSHeader from "./components/layouts/PGSHeader"
import PGSMain from "./components/layouts/PGSMain"
import Home from "./pages/Home"
import GlobalStyle from "./styles/GlobalStyle"

const App = () => {
  return (
    <>
      <GlobalStyle />
      <PGSHeader />
      <PGSMain>
        <Home />
      </PGSMain>
      <PGSFooter />
    </>
    
  )
}

export default App