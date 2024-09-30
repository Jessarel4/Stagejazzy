import { useState, useEffect } from "react";
import axios from "axios";
import "./topBox.scss";

interface Revenu {
  id_revenuPrimary: number;
  assiette_rrm: string;
  redevance: number;
  ristourne: number;
}

const TopBox = () => {
  const [topRevenus, setTopRevenus] = useState<Revenu[]>([]);
  const [period, setPeriod] = useState<string>("week");
  const [startDate, setStartDate] = useState<string>("");
  const [endDate, setEndDate] = useState<string>("");

  // Gestion des offsets pour la semaine, le mois et l'année
  const [weekOffset, setWeekOffset] = useState<number>(0);
  const [monthOffset, setMonthOffset] = useState<number>(0);
  const [yearOffset, setYearOffset] = useState<number>(0);

  useEffect(() => {
    const fetchTopRevenus = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/top-revenus", {
          params: { period, weekOffset, monthOffset, yearOffset }
        });
        setTopRevenus(response.data.topRevenus);
        setStartDate(response.data.startDate);
        setEndDate(response.data.endDate);
      } catch (error) {
        console.error("Erreur lors du chargement des données:", error);
      }
    };

    fetchTopRevenus();
  }, [period, weekOffset, monthOffset, yearOffset]);

  // Gestion des décalages pour la semaine, le mois et l'année
  const handlePreviousPeriod = () => {
    if (period === "week") {
      setWeekOffset((prev) => prev - 1);
    } else if (period === "month") {
      setMonthOffset((prev) => prev - 1);
    } else if (period === "year") {
      setYearOffset((prev) => prev - 1);
    }
  };

  const handleNextPeriod = () => {
    if (period === "week") {
      setWeekOffset((prev) => prev + 1);
    } else if (period === "month") {
      setMonthOffset((prev) => prev + 1);
    } else if (period === "year") {
      setYearOffset((prev) => prev + 1);
    }
  };

  const resetOffsets = () => {
    setWeekOffset(0);
    setMonthOffset(0);
    setYearOffset(0);
  };

  return (
    <div className="topBox">
      <h2>Top 5 des revenus par commune</h2>



      <div className="list">

      <div className="date">
        Période : <span className="res">{startDate} au {endDate}</span>
      </div>


      <div className="buttons">
        <button onClick={() => { setPeriod("week"); resetOffsets(); }}>Semaine</button>
        <button onClick={() => { setPeriod("month"); resetOffsets(); }}>Mois</button>
        <button onClick={() => { setPeriod("year"); resetOffsets(); }}>Année</button>
      </div>
        <div className="listItem header">
          <div className="user">
            <span className="username">Commune</span>
          </div>
          <span className="amount">Redevance</span>
          <span className="email">Ristourne</span>
        </div>
        {topRevenus.map((revenu) => (
          <div className="listItem" key={revenu.id_revenuPrimary}>
            <div className="user">
              <span className="username">{revenu.assiette_rrm}</span>
            </div>
            <span className="amount">{revenu.redevance} Ar</span>
            <span className="email">{revenu.ristourne} Ar</span>
          </div>
        ))}
      </div>

      <div className="navigationButtons">
        <button onClick={handlePreviousPeriod}>{"<<"}</button>
        <button onClick={handleNextPeriod}>{">>"}</button>
      </div>

      
    </div>
  );
};

export default TopBox;
