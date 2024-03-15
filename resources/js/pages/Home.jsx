import PGSSectionTitle from "../components/common/PGSSectionTitle"
import PGSContainer from "../components/layouts/PGSContainer"
import PGSSection from "../components/layouts/PGSSection"
import PGSHomeBanner from "../sections/PGSHomeBanner"
import PGSHomeButtons from "../sections/PGSHomeButtons"
import PGSHomeInfo from "../sections/PGSHomeInfo"

const Home = () => {
  return (
    <>
    <PGSHomeBanner />
    <PGSHomeButtons />
    <PGSHomeInfo />
    </>
  )
}

export default Home