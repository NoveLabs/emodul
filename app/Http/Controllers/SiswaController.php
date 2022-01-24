<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Materi;
use App\Models\Jawaban;
use App\Models\User;
use App\Models\Penilaian;

class SiswaController extends Controller
{
    private $modelMateri;
    
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:ROLE_SISWA');
        $this->modelMateri = new Materi();
        $this->modelJawaban = new Jawaban();
        $this->model = new User();

    }

    public function index()
    {
        return view('siswa.index');
    }

    public function profile()
    {
        $name = Auth::user()->name;
        $nama_sekolah = Auth::user()->nama_sekolah;
        $email = Auth::user()->email;

        return view('siswa.profile', compact('name', 'nama_sekolah', 'email'));
    }

    public function index_materi()
    {
        $lingkungan = 1;
        $sosial = 2;
        $kesehatan = 3;
        return view('materi.index_siswa', compact('lingkungan', 'sosial', 'kesehatan'));
    }

    public function materi_lingkungan($id)
    {
        $user_id = Auth::user()->id;
        $data = $this->modelMateri->getAllDataByTema($id, $user_id);
        $jawaban = $this->modelJawaban->getDataByUserId($user_id);
        
        $count = count($data);
        return view('materi.lingkungan.index', compact('data', 'count'));
    }

    public function soal_lingkungan($id)
    {
        $data = $this->modelMateri->getSingleData($id);
        $id_user = Auth::user()->id;
        return view('materi.lingkungan.soal', compact('data', 'id_user'));
    }

    public function video_lingkungan($id)
    {
        $data = $this->modelMateri->getSingleData($id);
        return view('materi.lingkungan.video', compact('data'));
    }

    public function jawaban_siswa_lingkungan($id, $userid)
    {
        $data = $this->modelJawaban->getSingleDataWithId($id, $userid);

        return view('materi.lingkungan.jawaban', compact('data'));
    }

    public function jawab_lingkungan(Request $request)
    {
        $data = $request->all();
        // $kata_kunci = json_encode($data['kata_kunci']);
        $pertanyaan = json_encode($data['pertanyaan']);

        $soal = $this->modelMateri->getSingleData($data['id_pertanyaan']);

        // foreach($data['kata_kunci'] as $dt) {
            $jawaban_nilai = str_contains($soal->teks_materi, $dt);
            if ($jawaban_nilai) {
                $nilai = 100;
            } else {
                $nilai = 0;
            }
        // }
        
        $dt_nilai = new Penilaian();

        $dt_nilai->nilai = $nilai;
        $dt_nilai->user_id = $data['user_id'];
        $dt_nilai->id_materi = $data['id_pertanyaan'];
        $dt_nilai->tema = 1;
        $dt_nilai->save();
        
        
        $find_data = $this->modelJawaban;

        $find_data->kata_kunci = $kata_kunci;
        $find_data->pertanyaan = $pertanyaan;
        $find_data->paragraf = $data['paragraf'];
        $find_data->user_id = $data['user_id'];
        $find_data->kalimat = $data['kalimat'];
        $find_data->id_pertanyaan = $data['id_pertanyaan'];

        $find_data->save();

        $dt = $this->modelMateri->getSingleData($data['id_pertanyaan']);

        return view('materi.lingkungan.review_video', compact('dt'));
    }

    public function materi_sosial($id)
    {
        $data = $this->modelMateri->getAllDataByTema($id);
        return view('materi.sosial.index', compact('data'));
    }

    public function soal_sosial($id)
    {
        $data = $this->modelMateri->getSingleData($id);
        $id_user = Auth::user()->id;
        return view('materi.sosial.soal', compact('data', 'id_user'));
    }

    public function video_sosial($id)
    {
        $data = $this->modelMateri->getSingleData($id);
        return view('materi.sosial.video', compact('data'));
    }

    public function jawab_sosial(Request $request)
    {
        $data = $request->all();
        $kata_kunci = json_encode($data['kata_kunci']);
        $pertanyaan = json_encode($data['pertanyaan']);

        $soal = $this->modelMateri->getSingleData($data['id_pertanyaan']);

        foreach($data['kata_kunci'] as $dt) {
            $jawaban_nilai = str_contains($soal->teks_materi, $dt);
            if ($jawaban_nilai) {
                $nilai = 100;
            } else {
                $nilai = 0;
            }
        }
        
        $dt_nilai = new Penilaian();

        $dt_nilai->nilai = $nilai;
        $dt_nilai->user_id = $data['user_id'];
        $dt_nilai->id_materi = $data['id_pertanyaan'];
        $dt_nilai->tema = 2;
        $dt_nilai->save();
        
        
        $find_data = $this->modelJawaban;

        $find_data->kata_kunci = $kata_kunci;
        $find_data->pertanyaan = $pertanyaan;
        $find_data->paragraf = $data['paragraf'];
        $find_data->user_id = $data['user_id'];
        $find_data->kalimat = $data['kalimat'];
        $find_data->id_pertanyaan = $data['id_pertanyaan'];

        $find_data->save();

        $dt = $this->modelMateri->getSingleData($data['id_pertanyaan']);

        return view('materi.sosial.review_video', compact('dt'));
    }

    public function materi_kesehatan($id)
    {
        $data = $this->modelMateri->getAllDataByTema($id);
        return view('materi.kesehatan.index', compact('data'));
    }

    public function soal_kesehatan($id)
    {
        $data = $this->modelMateri->getSingleData($id);
        $id_user = Auth::user()->id;
        return view('materi.kesehatan.soal', compact('data', 'id_user'));
    }

    public function video_kesehatan($id)
    {
        $data = $this->modelMateri->getSingleData($id);
        return view('materi.kesehatan.video', compact('data'));
    }

    public function jawab_kesehatan(Request $request)
    {
        $data = $request->all();
        $kata_kunci = json_encode($data['kata_kunci']);
        $pertanyaan = json_encode($data['pertanyaan']);

        $soal = $this->modelMateri->getSingleData($data['id_pertanyaan']);

        foreach($data['kata_kunci'] as $dt) {
            $jawaban_nilai = str_contains($soal->teks_materi, $dt);
            if ($jawaban_nilai) {
                $nilai = 100;
            } else {
                $nilai = 0;
            }
        }
        
        $dt_nilai = new Penilaian();

        $dt_nilai->nilai = $nilai;
        $dt_nilai->user_id = $data['user_id'];
        $dt_nilai->id_materi = $data['id_pertanyaan'];
        $dt_nilai->tema = 3;
        $dt_nilai->save();
        
        
        $find_data = $this->modelJawaban;

        $find_data->kata_kunci = $kata_kunci;
        $find_data->pertanyaan = $pertanyaan;
        $find_data->paragraf = $data['paragraf'];
        $find_data->user_id = $data['user_id'];
        $find_data->kalimat = $data['kalimat'];
        $find_data->id_pertanyaan = $data['id_pertanyaan'];

        $find_data->save();

        $dt = $this->modelMateri->getSingleData($data['id_pertanyaan']);

        return view('materi.kesehatan.review_video', compact('dt'));
    }

    public function profilePost(Request $request)
    {
        $data = $request->all();

        $find_data = $this->model->getSingleData($data['id']);

        $find_data->name = $data['name'];
        $find_data->nama_sekolah = $data['nama_sekolah'];
        $find_data->email = $data['email'];
        if($data['password'] != null) {
            $find_data->password = Hash::make($data['password']);
        }

        $find_data->save();

        return redirect('/profile/siswa');
    }

    public function profile_edit()
    {
        $data = Auth::user();

        return view('siswa.edit_profile', compact('data'));
    }
}
