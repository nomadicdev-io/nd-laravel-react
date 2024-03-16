import { Navigate, Route, Routes } from "react-router-dom"
import Home from "./routes/home"
import Layouts from "./routes/layouts"
import Team from "./routes/team"
import Gallery from "./routes/gallery"
import Projects from "./routes/projects"
import UIComponents from "./routes/uicomponents"

const PGSRoutes = () => { 
  return (
    <Routes>
        <Route path={'/'} element={<Home />}/>
        <Route path={'/ui-components'} element={<UIComponents />}/>
        <Route path={'/layouts'} element={<Layouts />}/>
        <Route path={'/team'} element={<Team />}/>
        <Route path={'/gallery'} element={<Gallery />}/>
        <Route path={'/projects'} element={<Projects />}/>
    </Routes>
  )
}

export default PGSRoutes