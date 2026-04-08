import { create } from "zustand";
import { CandidateAnalysis } from "../types/candidate";

interface CandidateState {
    analysis: CandidateAnalysis | null;
    isLoading: boolean;
    error: string | null;
    setAnalysis: (analysis: CandidateAnalysis | null) => void;
    setIsLoading: (isLoading: boolean) => void;
    setError: (error: string | null) => void;
    reset: () => void;
}

export const useCandidateStore = create<CandidateState>((set) => ({
    analysis: null,
    isLoading: false,
    error: null,
    setAnalysis: (analysis) => set({ analysis }),
    setIsLoading: (isLoading) => set({ isLoading }),
    setError: (error) => set({ error }),
    reset: () => set({ analysis: null, isLoading: false, error: null }),
}));
