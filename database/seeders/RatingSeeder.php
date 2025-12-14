<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\Ticket;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua tiket yang statusnya 'Selesai' (id = 6)
        $tickets = Ticket::where('ticket_statuses_id', 6)->get();

        foreach ($tickets as $ticket) {

            // Jika tidak ada responsible_id, skip
            if (!$ticket->responsible_id) {
                continue;
            }

            // Random rating 1–5
            $ratingValue = rand(1, 5);

            Rating::create([
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->owner_id,
                'rating' => $ratingValue,
                'comment' => $this->generateFeedback($ratingValue),
                'created_at' => $ticket->solved_at ?? now(),
                'updated_at' => $ticket->solved_at ?? now(),
            ]);
        }
    }

    /**
     * Generate feedback sesuai rating.
     */
    private function generateFeedback(int $rating): string
    {
        // Feedback bagus (rating 4–5)
        $positive = [
            'Pelayanan cepat dan responsif, terima kasih.',
            'Masalah terselesaikan dengan baik.',
            'Proses pengerjaan cukup cepat.',
            'Terima kasih, sangat membantu.',
            'Pengerjaan rapi dan sesuai permintaan.',
            'Petugas komunikatif dan profesional.',
        ];

        // Feedback jelek (rating 1–3)
        $negative = [
            'Penanganan sangat lambat dan tidak memuaskan.',
            'Masalah tidak benar-benar terselesaikan.',
            'Petugas kurang komunikatif selama proses.',
            'Harus follow-up berkali-kali untuk mendapat respon.',
            'Hasil pengerjaan tidak sesuai harapan.',
            'Tolong tingkatkan kualitas pelayanannya.',
        ];

        if ($rating >= 4) {
            // rating bagus
            return $positive[array_rand($positive)];
        }

        // rating 1–3 → feedback jelek
        return $negative[array_rand($negative)];
    }
}