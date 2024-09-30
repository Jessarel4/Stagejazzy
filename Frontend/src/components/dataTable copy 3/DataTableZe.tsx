import { useState, useEffect } from "react";
import { DataGrid, GridColDef } from "@mui/x-data-grid";
import axios from "axios";
import "./DataTableZe.scss";

// Fonction utilitaire pour obtenir le numéro de la semaine ISO
const getISOWeek = (date: Date) => {
  const firstThursday = new Date(date.getFullYear(), 0, 1 + (4 - new Date(date.getFullYear(), 0, 1).getDay()) % 7);
  return Math.ceil((((date.getTime() - firstThursday.getTime()) / 86400000) + 1) / 7);
};

const DataTableZe: React.FC = () => {
  const [rows, setRows] = useState([]);
  const [currentWeek, setCurrentWeek] = useState<number>(getISOWeek(new Date())); // Utiliser la fonction utilitaire
  const [currentMonth, setCurrentMonth] = useState<number>(new Date().getMonth() + 1);
  const [currentYear, setCurrentYear] = useState<number>(new Date().getFullYear());
  const [view, setView] = useState<"week" | "month" | "year">("week"); // Pour gérer la vue actuelle

  // Fonction pour charger les données
  const fetchData = async () => {
    try {
      let response;
      if (view === "week") {
        response = await axios.get(`http://127.0.0.1:8000/api/top-ze/${currentYear}/${currentWeek}`);
      } else if (view === "month") {
        response = await axios.get(`http://127.0.0.1:8000/api/top-ze-mois/${currentYear}/${currentMonth}`);
      } else if (view === "year") {
        response = await axios.get(`http://127.0.0.1:8000/api/top-ze-annee/${currentYear}`);
      }

      const topZe = response?.data?.topZe.map((item: any, index: number) => {
        let startDate = "";
        let endDate = "";

        if (view === "week") {
          const weekStart = new Date(item.year, 0, (item.week - 1) * 7 + 1); // Calculer le début de la semaine
          const weekEnd = new Date(item.year, 0, (item.week - 1) * 7 + 7); // Calculer la fin de la semaine
          startDate = weekStart.toISOString().split("T")[0]; // Format YYYY-MM-DD
          endDate = weekEnd.toISOString().split("T")[0]; // Format YYYY-MM-DD
        } else if (view === "month") {
          startDate = `${item.year}-${String(currentMonth).padStart(2, '0')}-01`; // Début du mois
          endDate = `${item.year}-${String(currentMonth).padStart(2, '0')}-${new Date(item.year, currentMonth, 0).getDate()}`; // Fin du mois
        } else if (view === "year") {
          startDate = `${item.year}-01-01`; // Début de l'année
          endDate = `${item.year}-12-31`; // Fin de l'année
        }

        return {
          id: index + 1,
          nom_ze: item.nom_ze,
          total_redevance: item.total_redevance,
          total_ristourne: item.total_ristourne,
          week: item.week,
          year: item.year,
          startDate,
          endDate,
        };
      }) || [];

      setRows(topZe);
    } catch (error) {
      console.error("Erreur lors du chargement des données:", error);
    }
  };

  useEffect(() => {
    fetchData();
  }, [currentWeek, currentMonth, currentYear, view]); // Récupérer les données chaque fois que la vue change

  const columns: GridColDef[] = [
    { field: 'id', headerName: 'ID', width: 90 },
    { field: 'nom_ze', headerName: 'Nom', width: 150 },
    { field: 'total_redevance', headerName: 'Total Redevance', width: 200 },
    { field: 'total_ristourne', headerName: 'Total Ristourne', width: 200 },
    { field: 'week', headerName: 'Semaine', width: 100 },
    { field: 'year', headerName: 'Année', width: 100 },
    { field: 'startDate', headerName: 'Date Début', width: 150 },
    { field: 'endDate', headerName: 'Date Fin', width: 150 },
  ];

  const goToPreviousWeek = () => {
    setCurrentWeek((prev) => (prev === 1 ? 52 : prev - 1)); // Ajuste selon l'année si nécessaire
  };

  const goToNextWeek = () => {
    setCurrentWeek((prev) => (prev === 52 ? 1 : prev + 1)); // Ajuste selon l'année si nécessaire
  };

  const goToPreviousMonth = () => {
    setCurrentMonth((prev) => (prev === 1 ? 12 : prev - 1)); // Gérer le changement de mois
  };

  const goToNextMonth = () => {
    setCurrentMonth((prev) => (prev === 12 ? 1 : prev + 1)); // Gérer le changement de mois
  };

  const goToPreviousYear = () => {
    setCurrentYear((prev) => prev - 1); // Gérer le changement d'année
  };

  const goToNextYear = () => {
    setCurrentYear((prev) => prev + 1); // Gérer le changement d'année
  };

  return (
    <div className="dataTable">
      <div className="view-navigation">
        
        <button onClick={() => setView("year")}>Année</button>
        <button onClick={() => setView("month")}>Mois</button>
        <button onClick={() => setView("week")}>Semaine</button>
        
        
      </div>
      {view === "week" && (
        <div className="week-navigation">
          <button onClick={goToPreviousWeek}>Semaine Précédente</button>
          <span>Semaine {currentWeek} {currentYear}</span>
          <button onClick={goToNextWeek}>Semaine Suivante</button>
        </div>
      )}
      {view === "month" && (
        <div className="month-navigation">
          <button onClick={goToPreviousMonth}>Mois Précédent</button>
          <span>Mois {currentMonth} {currentYear}</span>
          <button onClick={goToNextMonth}>Mois Suivant</button>
        </div>
      )}
      {view === "year" && (
        <div className="year-navigation">
          <button onClick={goToPreviousYear}>Année Précédente</button>
          <span>Année {currentYear}</span>
          <button onClick={goToNextYear}>Année Suivante</button>
        </div>
      )}
      <DataGrid
        rows={rows}
        columns={columns}
        pageSizeOptions={[5]}
        checkboxSelection
        disableRowSelectionOnClick
      />
      {rows.length === 0 && <p>Aucune donnée à afficher.</p>}
    </div>
  );
};

export default DataTableZe;
