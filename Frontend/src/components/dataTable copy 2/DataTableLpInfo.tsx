import { useState, useEffect } from "react";
import { DataGrid, GridColDef } from "@mui/x-data-grid";
import axios from "axios";
import "./DataTableLpInfo.scss";

interface LpInfo {
  id: number | null;
  month?: number | null;
  year?: number | null;
  total: number;
  startDate: string;
  endDate: string;
}

const DataTableLpInfo = () => {
  const [rows, setRows] = useState<LpInfo[]>([]);
  const [view, setView] = useState<'week' | 'month' | 'year'>('week');

  // Fonction pour calculer la date de début et de fin
  const getDates = (type: 'week' | 'month' | 'year', value: number) => {
    let startDate: Date;
    let endDate: Date;

    if (type === 'week') {
      const firstDayOfYear = new Date(new Date().getFullYear(), 0, 1);
      const daysToAdd = (value - 1) * 7 - firstDayOfYear.getDay() + 1;
      startDate = new Date(firstDayOfYear.setDate(firstDayOfYear.getDate() + daysToAdd));
      endDate = new Date(startDate);
      endDate.setDate(startDate.getDate() + 6);
    } else if (type === 'month') {
      startDate = new Date(new Date().getFullYear(), value - 1, 1);
      endDate = new Date(new Date().getFullYear(), value, 0);
    } else { // year
      startDate = new Date(value, 0, 1);
      endDate = new Date(value + 1, 0, 0);
    }

    return {
      startDate: startDate.toLocaleDateString(),
      endDate: endDate.toLocaleDateString(),
    };
  };

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/lp-stats");
        console.log("Données de l'API LP Info:", response.data);

        const { lpPerWeek, lpPerMonth, lpPerYear } = response.data;

        let formattedLpInfos: LpInfo[];

        if (view === 'week') {
          formattedLpInfos = lpPerWeek.filter((lpInfo: any) => lpInfo.week !== null).map((lpInfo: any) => {
            const { startDate, endDate } = getDates('week', lpInfo.week);
            return {
              id: lpInfo.week,
              month: null,
              year: null,
              total: lpInfo.total,
              startDate,
              endDate,
            };
          });
        } else if (view === 'month') {
          formattedLpInfos = lpPerMonth.filter((lpInfo: any) => lpInfo.month !== null).map((lpInfo: any) => {
            const { startDate, endDate } = getDates('month', lpInfo.month!);
            return {
              id: lpInfo.month,
              month: lpInfo.month,
              year: null,
              total: lpInfo.total,
              startDate,
              endDate,
            };
          });
        } else { // year
          formattedLpInfos = lpPerYear.filter((lpInfo: any) => lpInfo.year !== null).map((lpInfo: any) => {
            const { startDate, endDate } = getDates('year', lpInfo.year!);
            return {
              id: lpInfo.year,
              month: null,
              year: lpInfo.year,
              total: lpInfo.total,
              startDate,
              endDate,
            };
          });
        }

        setRows(formattedLpInfos);
        console.log("Rows après la mise à jour:", formattedLpInfos);
      } catch (error) {
        console.error("Erreur lors du chargement des données:", error);
      }
    };

    fetchData();
  }, [view]);

  const columns: GridColDef[] = [
    { field: 'id', headerName: 'ID', width: 90 },
    { field: view === 'week' ? 'week' : view === 'month' ? 'month' : 'year', headerName: view === 'week' ? 'Semaine' : view === 'month' ? 'Mois' : 'Année', width: 150 },
    { field: 'total', headerName: 'Total', width: 150 },
    { field: 'startDate', headerName: 'Date de Début', width: 150 },
    { field: 'endDate', headerName: 'Date de Fin', width: 150 },
  ];

  return (
    <div className="dataTable">
      <div>
        <button onClick={() => setView('week')}>Semaine</button>
        <button onClick={() => setView('month')}>Mois</button>
        <button onClick={() => setView('year')}>Année</button>
      </div>
      <DataGrid
        rows={rows}
        columns={columns}
        getRowId={(row) => row.id}
        initialState={{
          pagination: {
            paginationModel: {
              pageSize: 10,
            },
          },
        }}
        pageSizeOptions={[10]}
        checkboxSelection
        disableRowSelectionOnClick
      />
    </div>
  );
};

export default DataTableLpInfo;
